<script setup lang="ts">
import { computed, onBeforeUnmount, onMounted, ref } from 'vue';

// PROPS DARI LARAVEL: company_settings, projects, sliders
const props = defineProps<{
    settings?: Record<string, any>;
    projects?: Array<{ id: number; title: string; image?: string | null; category?: string | null; year?: string | number | null }>;
    sliders?: Array<{ id: number; title: string; image: string }>;
}>();

// Daftar slide: gunakan sliders dari database atau fallback ke gambar proyek
const slideItems = computed(() => {
    if (props.sliders && props.sliders.length > 0) {
        return props.sliders;
    }
    if (props.projects && props.projects.length > 0) {
        const withImg = props.projects.filter((p) => !!p.image);
        if (withImg.length > 0) {
            return withImg.map((p) => ({
                id: p.id,
                title: p.title,
                image: p.image as string,
            }));
        }
    }
    return [
        {
            id: 0,
            title: 'PT Hariq Sakti Konstruksindo',
            image: '/storage/sliders/J6OL5YFQ1Nd9R6931m2cblM0zaOZUv0jhN24f4Vw.jpg',
        },
    ];
});

// Slider index & timer autoplay
const currentIndex = ref(0);
let timer: ReturnType<typeof setInterval> | undefined;
const AUTO_SLIDE_DELAY = 4000; // 4 detik (standar auto-slide)

const stepNext = () => {
    if (slideItems.value.length === 0) return;
    currentIndex.value = (currentIndex.value + 1) % slideItems.value.length;
};

const startAutoplay = () => {
    stopAutoplay();
    if (slideItems.value.length > 1) {
        timer = setInterval(() => {
            stepNext();
        }, AUTO_SLIDE_DELAY);
    }
};

const stopAutoplay = () => {
    if (timer) {
        clearInterval(timer);
        timer = undefined;
    }
};

const nextSlide = () => {
    stepNext();
    startAutoplay(); // Reset timer saat diklik manual
};

const prevSlide = () => {
    if (slideItems.value.length === 0) return;
    currentIndex.value = (currentIndex.value - 1 + slideItems.value.length) % slideItems.value.length;
    startAutoplay(); // Reset timer saat diklik manual
};

const goToSlide = (i: number) => {
    currentIndex.value = i;
    startAutoplay();
};

const handleVisibilityChange = () => {
    if (document.hidden) {
        stopAutoplay();
    } else {
        startAutoplay();
    }
};

onMounted(() => {
    startAutoplay();
    document.addEventListener('visibilitychange', handleVisibilityChange);
});

onBeforeUnmount(() => {
    stopAutoplay();
    document.removeEventListener('visibilitychange', handleVisibilityChange);
});

const currentSlide = computed(() => slideItems.value[currentIndex.value]);
</script>

<template>
    <section
        id="beranda"
        class="relative w-full overflow-hidden border-b-2 border-zinc-900 bg-zinc-950 h-screen min-h-[600px] sm:min-h-[680px] flex items-center justify-center select-none pt-20"
    >
        <!-- Background Slider Images -->
        <div class="absolute inset-0 z-0">
            <div
                v-for="(s, i) in slideItems"
                :key="s.id ?? i"
                class="absolute inset-0 transition-opacity duration-1000 ease-in-out"
                :class="i === currentIndex ? 'opacity-100' : 'opacity-0 pointer-events-none'"
            >
                <img
                    :src="s.image"
                    :alt="s.title || 'Hero Background'"
                    class="h-full w-full object-cover object-center transform transition-transform duration-7000 ease-out"
                    :class="i === currentIndex ? 'scale-105' : 'scale-100'"
                />
            </div>
            <!-- Dark Overlay: lighter and balanced so background image details are vibrant and clear -->
            <div class="absolute inset-0 bg-gradient-to-t from-zinc-950/75 via-black/20 to-black/35 pointer-events-none"></div>
        </div>

        <!-- Centered Header Text (No CTA buttons as requested) -->
        <div class="relative z-10 mx-auto max-w-5xl px-6 sm:px-10 text-center flex flex-col items-center justify-center">
            <!-- Metadata / Kicker Tagline -->
            <div class="inline-flex items-center gap-2.5 px-4 py-1.5 rounded-full bg-black/40 backdrop-blur-md border border-white/20 text-orange-400 font-mono text-xs uppercase tracking-[0.2em] font-semibold mb-6 shadow-md">
                <span class="w-2 h-2 rounded-full bg-orange-500 animate-pulse"></span>
                <span>{{ settings?.company_name ?? 'PT. HARIQ SAKTI KONTRUKSINDO' }} — EST. {{ settings?.founded_year ?? '2012' }}</span>
            </div>

            <!-- Master Headline -->
            <h1 class="text-4xl sm:text-6xl md:text-7xl lg:text-8xl font-display font-extrabold text-white tracking-tight leading-[1.15] drop-shadow-2xl">
                Selamat Datang di <br class="hidden sm:inline" />
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-400 via-orange-500 to-amber-400 drop-shadow">
                    PT. Hariq Sakti
                </span>
                <span> Konstruksindo</span>
            </h1>

            <!-- Corporate Sub-headline / Tagline -->
            <p class="mt-5 sm:mt-7 max-w-3xl text-sm sm:text-base md:text-lg lg:text-xl text-zinc-200/95 font-normal leading-relaxed drop-shadow-md">
                {{ settings?.tagline ?? 'Kontraktor sipil dan struktur yang menepati jadwal, menjaga anggaran, dan tidak berkompromi pada keselamatan kerja. Dari gudang industri hingga gedung bertingkat.' }}
            </p>
        </div>

        <!-- Navigation Arrow: Previous (<) -->
        <button
            v-if="slideItems.length > 1"
            @click="prevSlide"
            aria-label="Slide Sebelumnya"
            class="absolute left-3 sm:left-8 top-1/2 -translate-y-1/2 z-20 flex h-12 w-12 sm:h-14 sm:w-14 items-center justify-center rounded-full text-white/80 transition-all hover:bg-black/40 hover:text-white hover:scale-110 active:scale-95 focus:outline-none"
        >
            <svg class="h-8 w-8 sm:h-10 sm:w-10 drop-shadow-md" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
        </button>

        <!-- Navigation Arrow: Next (>) -->
        <button
            v-if="slideItems.length > 1"
            @click="nextSlide"
            aria-label="Slide Berikutnya"
            class="absolute right-3 sm:right-8 top-1/2 -translate-y-1/2 z-20 flex h-12 w-12 sm:h-14 sm:w-14 items-center justify-center rounded-full text-white/80 transition-all hover:bg-black/40 hover:text-white hover:scale-110 active:scale-95 focus:outline-none"
        >
            <svg class="h-8 w-8 sm:h-10 sm:w-10 drop-shadow-md" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
            </svg>
        </button>

        <!-- Pagination Dots -->
        <div
            v-if="slideItems.length > 1"
            class="absolute bottom-6 sm:bottom-8 left-1/2 -translate-x-1/2 z-20 flex items-center gap-2.5 sm:gap-3"
        >
            <button
                v-for="(_, i) in slideItems"
                :key="i"
                @click="goToSlide(i)"
                :aria-label="`Pindah ke slide ${i + 1}`"
                class="rounded-full transition-all duration-300 focus:outline-none"
                :class="i === currentIndex ? 'w-3.5 h-3.5 sm:w-4 sm:h-4 bg-orange-500 ring-4 ring-orange-500/40 shadow-lg' : 'w-2.5 h-2.5 sm:w-3 sm:h-3 bg-white/50 hover:bg-white/90'"
            ></button>
        </div>

        <!-- Optional Slide Title Badge (bottom-right) -->
        <div
            v-if="currentSlide?.title"
            class="absolute bottom-6 right-6 hidden md:flex items-center gap-2 px-3 py-1.5 rounded-full bg-black/40 backdrop-blur-md border border-white/10 text-[11px] font-mono uppercase tracking-wider text-zinc-300 z-10"
        >
            <span class="w-1.5 h-1.5 rounded-full bg-orange-400"></span>
            <span>{{ currentSlide.title }}</span>
        </div>
    </section>
</template>
