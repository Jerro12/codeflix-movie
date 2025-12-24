<div class="relative w-full aspect-video bg-black rounded-xl overflow-hidden group" 
     x-data="videoPlayer(@js($progress))"
     @keydown.window="handleKeyboard($event)">
    
    <!-- Video Element -->
    <video x-ref="video"
           class="w-full h-full object-contain"
           @timeupdate="onTimeUpdate"
           @loadedmetadata="onLoadedMetadata"
           @play="isPlaying = true"
           @pause="isPlaying = false"
           @ended="onEnded"
           preload="metadata">
        <source src="{{ $videoUrl }}" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    <!-- Loading Overlay -->
    <div x-show="isLoading" class="absolute inset-0 flex items-center justify-center bg-black/50">
        <div class="w-16 h-16 border-4 border-codeflix-primary border-t-transparent rounded-full animate-spin"></div>
    </div>

    <!-- Controls Overlay -->
    <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-black/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col">
        
        <!-- Top Bar -->
        <div class="flex items-center justify-between p-4">
            <a href="{{ route('home') }}" class="text-white hover:text-codeflix-primary transition">
                <i class="fa-solid fa-arrow-left text-xl"></i>
            </a>
            <h1 class="font-outfit font-semibold text-white text-lg">{{ $movie->title }}</h1>
            <div></div>
        </div>

        <!-- Center Play Button -->
        <div class="flex-1 flex items-center justify-center">
            <button @click="togglePlay" 
                    class="w-20 h-20 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center hover:bg-white/30 transition">
                <i class="fa-solid" :class="isPlaying ? 'fa-pause' : 'fa-play'" 
                   x-text="isPlaying ? '' : ''" class="text-white text-3xl ml-1"></i>
                <template x-if="isPlaying">
                    <i class="fa-solid fa-pause text-white text-3xl"></i>
                </template>
                <template x-if="!isPlaying">
                    <i class="fa-solid fa-play text-white text-3xl ml-1"></i>
                </template>
            </button>
        </div>

        <!-- Bottom Controls -->
        <div class="p-4 space-y-3">
            <!-- Progress Bar -->
            <div class="relative w-full h-1 bg-gray-700 rounded-full cursor-pointer group/progress"
                 @click="seek($event)">
                <div class="absolute h-full bg-codeflix-primary rounded-full transition-all"
                     :style="'width: ' + progress + '%'"></div>
                <div class="absolute h-3 w-3 bg-codeflix-primary rounded-full -top-1 opacity-0 group-hover/progress:opacity-100 transition"
                     :style="'left: calc(' + progress + '% - 6px)'"></div>
            </div>

            <div class="flex items-center justify-between">
                <!-- Left Controls -->
                <div class="flex items-center gap-4">
                    <button @click="togglePlay" class="text-white hover:text-codeflix-primary transition">
                        <i class="fa-solid text-xl" :class="isPlaying ? 'fa-pause' : 'fa-play'"></i>
                    </button>
                    <button @click="skip(-10)" class="text-white hover:text-codeflix-primary transition">
                        <i class="fa-solid fa-rotate-left text-lg"></i>
                        <span class="text-xs">10</span>
                    </button>
                    <button @click="skip(10)" class="text-white hover:text-codeflix-primary transition">
                        <i class="fa-solid fa-rotate-right text-lg"></i>
                        <span class="text-xs">10</span>
                    </button>
                    <button @click="toggleMute" class="text-white hover:text-codeflix-primary transition">
                        <i class="fa-solid text-xl" :class="isMuted ? 'fa-volume-xmark' : 'fa-volume-high'"></i>
                    </button>
                    <span class="text-white text-sm" x-text="formatTime(currentTime) + ' / ' + formatTime(totalDuration)"></span>
                </div>

                <!-- Right Controls -->
                <div class="flex items-center gap-4">
                    <!-- Quality Selector -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="text-white hover:text-codeflix-primary transition flex items-center gap-1">
                            <i class="fa-solid fa-gear"></i>
                            <span class="text-sm">{{ $currentQuality }}p</span>
                        </button>
                        <div x-show="open" @click.away="open = false"
                             class="absolute bottom-full right-0 mb-2 bg-codeflix-card border border-gray-800 rounded-lg shadow-xl overflow-hidden">
                            @if($movie->url_720)
                            <button wire:click="changeQuality('720')" 
                                    class="block w-full px-4 py-2 text-left hover:bg-gray-800 {{ $currentQuality == '720' ? 'text-codeflix-primary' : 'text-white' }}">
                                720p
                            </button>
                            @endif
                            @if($movie->url_1080)
                            <button wire:click="changeQuality('1080')"
                                    class="block w-full px-4 py-2 text-left hover:bg-gray-800 {{ $currentQuality == '1080' ? 'text-codeflix-primary' : 'text-white' }}">
                                1080p
                            </button>
                            @endif
                            @if($movie->url_4k)
                            <button wire:click="changeQuality('4k')"
                                    class="block w-full px-4 py-2 text-left hover:bg-gray-800 {{ $currentQuality == '4k' ? 'text-codeflix-primary' : 'text-white' }}">
                                4K
                            </button>
                            @endif
                        </div>
                    </div>
                    <button @click="toggleFullscreen" class="text-white hover:text-codeflix-primary transition">
                        <i class="fa-solid text-xl" :class="isFullscreen ? 'fa-compress' : 'fa-expand'"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Keyboard Shortcuts Info (shown briefly on load) -->
    <div x-show="showShortcuts" x-transition class="absolute top-4 right-4 bg-black/80 rounded-lg p-3 text-white text-sm">
        <p><kbd class="bg-gray-700 px-2 py-1 rounded">Space</kbd> Play/Pause</p>
        <p><kbd class="bg-gray-700 px-2 py-1 rounded">←/→</kbd> Skip 10s</p>
        <p><kbd class="bg-gray-700 px-2 py-1 rounded">M</kbd> Mute</p>
        <p><kbd class="bg-gray-700 px-2 py-1 rounded">F</kbd> Fullscreen</p>
    </div>
</div>

<script>
function videoPlayer(savedProgress) {
    return {
        isPlaying: false,
        isMuted: false,
        isFullscreen: false,
        isLoading: true,
        showShortcuts: false,
        progress: 0,
        currentTime: 0,
        totalDuration: 0,

        init() {
            // Show shortcuts briefly
            this.showShortcuts = true;
            setTimeout(() => this.showShortcuts = false, 3000);
        },

        onLoadedMetadata() {
            this.totalDuration = this.$refs.video.duration;
            this.isLoading = false;
            
            // Resume from saved progress
            if (savedProgress > 0) {
                this.$refs.video.currentTime = savedProgress;
            }
        },

        onTimeUpdate() {
            this.currentTime = this.$refs.video.currentTime;
            this.progress = (this.currentTime / this.totalDuration) * 100;
            
            // Save progress every 5 seconds
            if (Math.floor(this.currentTime) % 5 === 0) {
                this.$wire.saveProgress(Math.floor(this.currentTime), Math.floor(this.totalDuration));
            }
        },

        onEnded() {
            this.isPlaying = false;
            this.$wire.saveProgress(Math.floor(this.totalDuration), Math.floor(this.totalDuration));
        },

        togglePlay() {
            if (this.$refs.video.paused) {
                this.$refs.video.play();
            } else {
                this.$refs.video.pause();
            }
        },

        toggleMute() {
            this.isMuted = !this.isMuted;
            this.$refs.video.muted = this.isMuted;
        },

        toggleFullscreen() {
            if (!document.fullscreenElement) {
                this.$el.requestFullscreen();
                this.isFullscreen = true;
            } else {
                document.exitFullscreen();
                this.isFullscreen = false;
            }
        },

        skip(seconds) {
            this.$refs.video.currentTime += seconds;
        },

        seek(event) {
            const rect = event.target.getBoundingClientRect();
            const percent = (event.clientX - rect.left) / rect.width;
            this.$refs.video.currentTime = percent * this.totalDuration;
        },

        handleKeyboard(event) {
            if (event.target.tagName === 'INPUT') return;
            
            switch(event.code) {
                case 'Space':
                    event.preventDefault();
                    this.togglePlay();
                    break;
                case 'ArrowLeft':
                    this.skip(-10);
                    break;
                case 'ArrowRight':
                    this.skip(10);
                    break;
                case 'KeyM':
                    this.toggleMute();
                    break;
                case 'KeyF':
                    this.toggleFullscreen();
                    break;
            }
        },

        formatTime(seconds) {
            const hrs = Math.floor(seconds / 3600);
            const mins = Math.floor((seconds % 3600) / 60);
            const secs = Math.floor(seconds % 60);
            
            if (hrs > 0) {
                return `${hrs}:${mins.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
            }
            return `${mins}:${secs.toString().padStart(2, '0')}`;
        }
    }
}
</script>
