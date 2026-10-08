<script setup lang="ts">
import { computed, onBeforeUnmount, onMounted, ref } from 'vue';

// PROPS DARI LARAVEL: company_settings, projects (cadangan gambar), sliders (hero banner dari menu Sliders)
const props = defineProps<{
    settings: Record<string, any>;
    projects: Array<{ id: number; title: string; image: string; category?: string; year?: string | number }>;
    sliders?: Array<{ id: number; title: string; subtitle?: string | null; image: string; button_text?: string | null; button_url?: string | null }>;
}>();

// Slider aktif berputar tiap 5 detik jika lebih dari satu
const index = ref(0);
let timer: ReturnType<typeof setInterval> | undefined;
onMounted(() => {
    if ((props.sliders?.length ?? 0) > 1) timer = setInterval(() => (index.value = (index.value + 1) % props.sliders!.length), 5000);
});
onBeforeUnmount(() => clearInterval(timer));

const slide = computed(() => props.sliders?.[index.value]);
const featured = computed(() => props.projects?.[0]);
const stats = computed(() => [
    { value: props.settings?.years_experience ?? '12+', label: 'Tahun Pengalaman' },
    { value: props.settings?.projects_done ?? '250+', label: 'Proyek Selesai' },
    { value: props.settings?.engineers ?? '80', label: 'Tenaga Ahli' },
]);
</script>

<template>
    <section id="beranda" class="border-b-2 border-zinc-900">
        <div class="mx-auto grid max-w-[1440px] grid-cols-12">
            <!-- Kolom kiri: headline raksasa -->
            <div class="col-span-12 flex flex-col justify-between border-zinc-900 px-5 pb-10 pt-16 sm:px-10 lg:col-span-8 lg:border-r-2 lg:pt-28">
                <p class="mb-8 font-mono text-xs uppercase tracking-[0.25em] text-zinc-500">
                    <!-- PROPS: nama perusahaan dari company_settings -->
                    {{ settings?.company_name ?? 'PT Hariq Sakti Konstruksindo' }} — Est. {{ settings?.founded_year ?? '2012' }}
                </p>

                <div class="relative z-10">
                    <!-- Glow effect di belakang teks -->
                    <div class="absolute -inset-x-10 -inset-y-5 -z-10 bg-gradient-to-tr from-orange-200/40 via-transparent to-amber-200/30 blur-3xl rounded-full"></div>
                    
                    <h1 class="text-[clamp(3rem,9vw,7.5rem)] font-extrabold leading-[0.95] tracking-tight text-zinc-900">
                        <span class="block opacity-90 transition-opacity hover:opacity-100">Kami</span>
                        <span class="block w-fit bg-gradient-to-r from-orange-600 via-orange-500 to-amber-500 bg-clip-text text-transparent pb-4 -mb-4 drop-shadow-sm transition-transform duration-500 hover:scale-105 hover:drop-shadow-lg cursor-default">
                            membangun
                        </span>
                        <span class="block opacity-90 transition-opacity hover:opacity-100">yang bertahan<span class="text-orange-600">.</span></span>
                    </h1>
                </div>

                <div class="mt-14 grid gap-8 md:grid-cols-2">
                    <!-- PROPS: tagline dari company_settings -->
                    <p class="max-w-md text-lg leading-relaxed text-zinc-600">
                        {{ settings?.tagline ?? 'Kontraktor sipil dan struktur yang menepati jadwal, menjaga anggaran, dan tidak berkompromi pada keselamatan kerja. Dari gudang industri hingga gedung bertingkat.' }}
                    </p>
                    <div class="flex flex-col sm:flex-row sm:items-center gap-6 md:justify-end md:pb-2">
                        <a href="#kontak" class="group inline-flex items-center justify-center gap-3 bg-zinc-900 px-8 py-4 text-sm font-bold uppercase tracking-wider text-zinc-50 transition-all hover:bg-orange-600 hover:-translate-y-1 hover:shadow-[4px_4px_0_0_#ea580c]">
                            Diskusikan Proyek
                            <span class="transition-transform group-hover:translate-x-1">&rarr;</span>
                        </a>
                        <a href="#proyek" class="group inline-flex items-center justify-center gap-2 border-b-2 border-zinc-900 pb-1 text-sm font-bold uppercase tracking-wider text-zinc-900 transition-colors hover:border-orange-600 hover:text-orange-600">
                            Lihat Portofolio
                            <span class="opacity-0 -ml-2 transition-all group-hover:ml-0 group-hover:opacity-100">&rarr;</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Kolom kanan: gambar proyek unggulan + statistik -->
            <div class="col-span-12 grid grid-rows-[1fr_auto] lg:col-span-4">
                <div class="relative min-h-[320px] overflow-hidden border-t-2 border-zinc-900 bg-zinc-200 lg:border-t-0">
                    <!-- PROPS: gambar, judul, subjudul & tombol dari sliders (fallback: proyek pertama) -->
                    <template v-if="slide">
                        <img v-for="(s, i) in sliders" :key="s.id" :src="s.image" :alt="s.title"
                            class="absolute inset-0 h-full w-full object-cover transition-opacity duration-1000"
                            :class="i === index ? 'opacity-100' : 'opacity-0'" />
                        <div class="absolute bottom-0 left-0 right-0 bg-zinc-50 px-4 py-3 text-xs">
                            <p class="font-mono uppercase">{{ slide.title }}</p>
                            <p v-if="slide.subtitle" class="mt-1 text-zinc-600">{{ slide.subtitle }}</p>
                            <a v-if="slide.button_text && slide.button_url" :href="slide.button_url"
                                class="mt-2 inline-block border-b-2 border-zinc-900 font-semibold uppercase hover:border-orange-600 hover:text-orange-600">
                                {{ slide.button_text }} →
                            </a>
                        </div>
                    </template>
                    <template v-else-if="featured">
                        <img :src="featured.image" :alt="featured.title"
                            class="absolute inset-0 h-full w-full object-cover grayscale transition duration-700 hover:grayscale-0" />
                        <div class="absolute bottom-0 left-0 bg-zinc-50 px-4 py-3 font-mono text-xs uppercase">
                            Proyek Terbaru — {{ featured.title }}
                        </div>
                    </template>
                </div>
                <!-- PROPS: statistik dari company_settings -->
                <dl class="grid grid-cols-3 border-t-2 border-zinc-900">
                    <div v-for="(s, i) in stats" :key="s.label" class="p-5" :class="{ 'border-l-2 border-zinc-900': i > 0 }">
                        <dt class="text-3xl font-black tracking-tight">{{ s.value }}</dt>
                        <dd class="mt-1 text-[11px] uppercase leading-tight tracking-wider text-zinc-500">{{ s.label }}</dd>
                    </div>
                </dl>
            </div>
        </div>
    </section>
</template>
