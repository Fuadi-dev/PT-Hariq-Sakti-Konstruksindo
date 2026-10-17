<script setup lang="ts">
import { computed, onBeforeUnmount, onMounted, ref } from 'vue';

// PROPS DARI LARAVEL: company_settings, projects, sliders
const props = defineProps<{
    settings: Record<string, any>;
    projects: Array<{ id: number; title: string; image?: string | null; category?: string | null; year?: string | number | null }>;
    sliders?: Array<{ id: number; title: string; subtitle?: string | null; image: string; button_text?: string | null; button_url?: string | null }>;
}>();

// Slider aktif berputar tiap 5 detik jika lebih dari satu
const index = ref(0);
let timer: ReturnType<typeof setInterval> | undefined;
onMounted(() => {
    if ((props.sliders?.length ?? 0) > 1) {
        timer = setInterval(() => (index.value = (index.value + 1) % props.sliders!.length), 5000);
    }
});
onBeforeUnmount(() => {
    if (timer) clearInterval(timer);
});

const slide = computed(() => props.sliders?.[index.value]);
const featured = computed(() => props.projects?.[0]);
const stats = computed(() => [
    { value: props.settings?.years_experience ?? '12+', label: 'Tahun Pengalaman' },
    { value: props.settings?.projects_done ?? '250+', label: 'Proyek Selesai' },
    { value: props.settings?.engineers ?? '80', label: 'Tenaga Ahli' },
]);
</script>

<template>
    <section id="beranda" class="border-b-2 border-zinc-900 bg-white lg:h-[calc(100vh-5rem)] lg:min-h-[580px] lg:overflow-hidden">
        <div class="mx-auto grid max-w-[1440px] grid-cols-12 w-full lg:h-full">
            <!-- Kolom kiri: Copywriting, Headline, Subheadline & Tombol Aksi -->
            <div class="col-span-12 flex flex-col justify-center border-zinc-900 px-6 sm:px-10 lg:px-14 py-10 lg:py-12 lg:col-span-7 lg:border-r-2 lg:h-full">
                <div class="relative z-10 space-y-6 lg:space-y-7 max-w-2xl">
                    <!-- Glow effect di belakang teks -->
                    <div class="absolute -inset-x-10 -inset-y-5 -z-10 bg-gradient-to-tr from-orange-200/40 via-transparent to-amber-200/30 blur-3xl rounded-full pointer-events-none"></div>

                    <!-- Metadata Tagline -->
                    <div class="inline-flex items-center gap-3">
                        <span class="w-2.5 h-2.5 bg-brand-orange flex-shrink-0"></span>
                        <p class="font-mono text-xs uppercase tracking-[0.2em] font-semibold text-zinc-500 font-display">
                            {{ settings?.company_name ?? 'PT HARIQ SAKTI KONTRUKSINDO' }} — EST. {{ settings?.founded_year ?? '2012' }}
                        </p>
                    </div>
                    
                    <!-- Master Headline -->
                    <h1 class="text-5xl sm:text-6xl lg:text-7xl xl:text-8xl font-display font-extrabold text-zinc-950 headline-tight">
                        Kami <br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-600 via-orange-500 to-amber-500 drop-shadow-sm inline-block">
                            membangun
                        </span> <br>
                        yang bertahan<span class="text-brand-orange">.</span>
                    </h1>

                    <!-- Corporate Sub-headline -->
                    <p class="text-sm sm:text-base lg:text-lg text-zinc-600 max-w-xl leading-relaxed">
                        {{ settings?.tagline ?? 'Kontraktor sipil dan struktur yang menepati jadwal, menjaga anggaran, dan tidak berkompromi pada keselamatan kerja. Dari gudang industri hingga gedung bertingkat.' }}
                    </p>

                    <!-- Action Buttons Group -->
                    <div class="pt-2 flex flex-wrap items-center gap-4 sm:gap-6">
                        <a href="#kontak" class="group inline-flex items-center justify-center gap-3 bg-zinc-950 px-7 py-3.5 sm:px-8 sm:py-4 text-xs sm:text-sm font-bold uppercase tracking-wider text-zinc-50 transition-all hover:bg-orange-600 hover:-translate-y-0.5 hover:shadow-[4px_4px_0_0_#ea580c] whitespace-nowrap">
                            <span>Diskusikan Proyek</span>
                            <span class="transition-transform group-hover:translate-x-1 text-base">&rarr;</span>
                        </a>
                        <a href="#proyek" class="group inline-flex items-center justify-center gap-2 border-b-2 border-zinc-900 pb-1 text-xs sm:text-sm font-bold uppercase tracking-wider text-zinc-900 transition-colors hover:border-orange-600 hover:text-orange-600 whitespace-nowrap">
                            <span>Lihat Portofolio</span>
                            <span class="opacity-0 -ml-2 transition-all group-hover:ml-0 group-hover:opacity-100">&rarr;</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Kolom kanan: gambar proyek unggulan + statistik -->
            <div class="col-span-12 grid grid-rows-[1fr_auto] lg:col-span-5 lg:h-full border-t-2 border-zinc-900 lg:border-t-0">
                <div class="relative w-full h-full min-h-[300px] lg:min-h-0 overflow-hidden bg-zinc-900">
                    <!-- PROPS: gambar, judul, subjudul & tombol dari sliders (fallback: proyek pertama) -->
                    <template v-if="slide">
                        <img v-for="(s, i) in sliders" :key="s.id" :src="s.image" :alt="s.title"
                            class="absolute inset-0 h-full w-full object-cover object-center transition-opacity duration-1000"
                            :class="i === index ? 'opacity-100' : 'opacity-0'" />
                        <div class="absolute bottom-0 left-0 right-0 bg-zinc-900/85 backdrop-blur-sm px-5 py-3 text-xs text-white border-t border-white/10 z-10 flex items-center justify-between">
                            <div>
                                <p class="font-mono uppercase font-bold text-xs tracking-wider text-white">{{ slide.title }}</p>
                                <p v-if="slide.subtitle" class="mt-0.5 text-[11px] text-zinc-300">{{ slide.subtitle }}</p>
                            </div>
                            <a v-if="slide.button_text && slide.button_url" :href="slide.button_url"
                                class="inline-block border-b border-orange-400 text-orange-400 font-semibold uppercase text-xs hover:text-white hover:border-white transition-colors">
                                {{ slide.button_text }} →
                            </a>
                        </div>
                    </template>
                    <template v-else-if="featured && featured.image">
                        <img :src="featured.image" :alt="featured.title"
                            class="absolute inset-0 h-full w-full object-cover object-center grayscale transition duration-700 hover:grayscale-0" />
                        <div class="absolute bottom-0 left-0 right-0 bg-zinc-900/85 backdrop-blur-sm px-5 py-3 font-mono text-xs uppercase text-white border-t border-white/10">
                            Proyek Unggulan — {{ featured.title }}
                        </div>
                    </template>
                </div>
                <!-- PROPS: statistik dari company_settings -->
                <dl class="grid grid-cols-3 border-t-2 border-zinc-900 bg-white flex-shrink-0">
                    <div v-for="(s, i) in stats" :key="s.label" class="p-4 sm:p-5 flex flex-col justify-center" :class="{ 'border-l-2 border-zinc-900': i > 0 }">
                        <dt class="text-2xl sm:text-3xl xl:text-4xl font-black tracking-tight font-display text-zinc-900">{{ s.value }}</dt>
                        <dd class="mt-1 text-[10px] sm:text-[11px] uppercase leading-tight tracking-wider text-zinc-500 font-semibold">{{ s.label }}</dd>
                    </div>
                </dl>
            </div>
        </div>
    </section>
</template>
