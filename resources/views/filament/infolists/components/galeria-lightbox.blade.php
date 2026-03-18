<div x-data="{
    index: 0,
    zoom: 1,
    images: @js($img),

    next() {
        this.index = (this.index + 1) % this.images.length
        this.zoom = 1
    },

    prev() {
        this.index = (this.index - 1 + this.images.length) % this.images.length
        this.zoom = 1
    },

    zoomIn() {
        this.zoom = Math.min(this.zoom + 0.2, 3)
    },

    zoomOut() {
        this.zoom = Math.max(this.zoom - 0.2, 1)
    }
}" class="w-full" @keydown.window.prevent.arrow-right="next()"
    @keydown.window.prevent.arrow-left="prev()" @keydown.window.escape="closeModal ? closeModal() : null">

    <!-- IMAGEN PRINCIPAL -->
    <div class="relative flex justify-center items-center mb-4 overflow-hidden">

        <img :src="images[index]?.url" class="max-h-[70vh] rounded-lg transition-transform duration-200 cursor-zoom-in"
            :style="'transform: scale(' + zoom + ')'" @wheel.prevent="event.deltaY < 0 ? zoomIn() : zoomOut()">

        <!-- Flecha izquierda -->
        <button type="button" @click="prev()" class="absolute left-2 bg-white/80 hover:bg-white p-2 rounded-full shadow">
            ◀
        </button>

        <!-- Flecha derecha -->
        <button type="button" @click="next()" class="absolute right-2 bg-white/80 hover:bg-white p-2  shadow">
            ▶
        </button>

    </div>


</div>
