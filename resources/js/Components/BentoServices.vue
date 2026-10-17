<script setup lang="ts">
import { computed } from 'vue';

interface Service {
    id: number;
    title: string;
    slug?: string;
    description: string;
    icon?: string | null;
}

const props = defineProps<{ services: Service[] }>();

// Konfigurasi tema bento sesuai desain code.html
const cardThemes = [
    {
        key: 'pemeliharaan',
        colClass: 'lg:col-span-7 bg-zinc-950 text-white p-8 md:p-10 flex flex-col justify-between bento-card border border-sky-900/60 shadow-xl relative overflow-hidden group',
        glowClass: 'absolute top-0 right-0 w-72 h-72 bg-sky-500/10 rounded-full blur-3xl pointer-events-none',
        categoryTag: 'CIVIL & MEP MAINTENANCE',
        pillTag: 'GARANSI MUTU',
        pillClass: 'bg-sky-950 border border-sky-600/40 text-[11px] text-sky-300 font-semibold',
        numClass: 'px-2 py-0.5 rounded bg-sky-500/20 text-sky-400 font-bold border border-sky-400/30',
        catClass: 'text-sky-300 tracking-wider font-semibold',
        imgAspect: 'aspect-[16/9]',
        imgBorder: 'border border-zinc-800',
        badgeImg: 'PREVENTIVE & EMERGENCY',
        badgeImgClass: 'bg-zinc-950/80 border border-sky-500/30 text-sky-300',
        titleHover: 'group-hover:text-sky-300',
        descClass: 'text-zinc-300 text-sm sm:text-base leading-relaxed',
        footerBorder: 'border-t border-zinc-800',
        footerDot: 'w-2 h-2 rounded-full bg-sky-400 animate-ping',
        footerText: 'Pencegahan Kerusakan Dini • SLA 24 Jam',
        footerTextColor: 'text-sky-400',
        arrowBtn: 'w-8 h-8 rounded-full bg-sky-500/20 text-sky-400 flex items-center justify-center text-sm font-bold border border-sky-400/40 group-hover:bg-sky-500 group-hover:text-zinc-950 transition-colors',
        fallbackImg: 'https://lh3.googleusercontent.com/aida-public/AB6AXuDqRWuIIU0-CwAgPpjMcRPfR1gNZhGP-6kp-_vPX_TCIA2mNwerz-ffmXiYsWpzKKWAOgPwrV745J1TlvTvOTfJdLEHXrRP5yc_r1IGf39xHqfeoCYJipI7qCQcNbzYwnETsgkSyX1jIrIh49gnwzHMZdNUBNWXYuXTCIJSyfgP7-PCx0wNwd89vq9frZiJmZfxRD3QA0VW6pXQOTGaCJhAJYFwx0DsRvIXBku3atHf6hJ1B8eMZnSV',
    },
    {
        key: 'lingkungan',
        colClass: 'lg:col-span-5 bg-gradient-to-br from-emerald-900 via-emerald-800 to-teal-950 text-white p-8 md:p-10 flex flex-col justify-between bento-card border border-emerald-600/50 shadow-xl relative overflow-hidden group',
        glowClass: 'absolute top-0 right-0 w-64 h-64 bg-emerald-400/10 rounded-full blur-2xl pointer-events-none',
        categoryTag: 'AMDAL & GREEN BUILDING',
        pillTag: 'ZERO ACCIDENT',
        pillClass: 'bg-emerald-950 border border-emerald-400/50 text-[11px] text-emerald-300 font-bold',
        numClass: 'px-2 py-0.5 rounded bg-emerald-400/20 text-emerald-300 font-bold border border-emerald-300/40',
        catClass: 'text-emerald-200 tracking-wider font-semibold',
        imgAspect: 'aspect-[16/10]',
        imgBorder: 'border border-emerald-700/60',
        badgeImg: 'ISO 14001:2015',
        badgeImgClass: 'bg-emerald-950/80 border border-emerald-400/30 text-emerald-200',
        titleHover: 'group-hover:text-emerald-200',
        descClass: 'text-emerald-100 text-sm sm:text-base leading-relaxed',
        footerBorder: 'border-t border-emerald-700/50',
        footerDot: 'w-2 h-2 rounded-full bg-emerald-300',
        footerText: 'Kepatuhan Regulasi Penuh & SMK3',
        footerTextColor: 'text-emerald-200',
        arrowBtn: 'w-8 h-8 rounded-full bg-white/20 text-white flex items-center justify-center text-sm font-bold border border-white/30 group-hover:bg-white group-hover:text-emerald-900 transition-colors',
        fallbackImg: 'https://lh3.googleusercontent.com/aida-public/AB6AXuCjLf1gHZbtgEK4tBwwEW5-SVC1rONIcQ2Gh8X_3kyoR_fDIvuaSLbsV-Au-3GjV6Kxm0z0_Ah-OP_N1-Fx0zJXo-eJq4lALFbB30k0LKVXEzadTyci6oYBEAxnBbLMC1-DCHXtn7tqqyn9ZArhqbmD0AMN-mr3AKzValX_26YygWN4_AoRtfg7h3wlVYg7tjQQcVvcwEo2rYz5vFE1roSO5-G6K2Hw-9Mo1WWwn_byYETNqOm2Xy8j',
    },
    {
        key: 'konsultasi',
        colClass: 'lg:col-span-4 bg-white border-2 border-blue-200/80 hover:border-blue-500 p-8 flex flex-col justify-between bento-card shadow-sm group',
        glowClass: '',
        categoryTag: 'BLUEPRINT & RAB',
        pillTag: 'BIM 3D',
        pillClass: 'text-[11px] font-semibold text-blue-600 bg-blue-50 px-2 py-0.5 rounded',
        numClass: 'px-2 py-0.5 rounded bg-blue-100 text-blue-700 font-bold border border-blue-200',
        catClass: 'text-blue-700 font-bold',
        imgAspect: 'aspect-[16/10]',
        imgBorder: 'border border-zinc-200',
        badgeImg: '',
        badgeImgClass: '',
        titleHover: 'group-hover:text-blue-600',
        descClass: 'text-zinc-600 text-sm leading-relaxed',
        footerBorder: 'border-t border-blue-100',
        footerDot: '',
        footerText: 'STUDI KELAYAKAN & STRUKTUR',
        footerTextColor: 'text-blue-700',
        arrowBtn: 'text-blue-600 text-sm font-bold group-hover:translate-x-1 transition-transform',
        fallbackImg: 'https://lh3.googleusercontent.com/aida-public/AB6AXuCfBuc3osWRnILm8j-tohg9_mfW8L3UcGVilgMZqMEYYV756qDQ60aZCnDavCV0SWJb58GXsa9rj4INL1FNeWsEJETRGiV4_DxivTy9fHCJCvgcuFNs9gEIgskCJrevMOYpKe30Tpz0Y57wqYYpFOe9UJcG0_tTIOZlzPwCpl4_GxNIY6R_r9GZY9aobApZK_hEHQCdayrWPzHcpS4bBIixnyBo2nV8VP5YfmrBRmI9hO2Ct9goaJ-Z',
    },
    {
        key: 'pembangunan',
        colClass: 'lg:col-span-4 bg-white border-2 border-orange-200/80 hover:border-orange-500 p-8 flex flex-col justify-between bento-card shadow-sm group',
        glowClass: '',
        categoryTag: 'CIVIL & STRUCTURE',
        pillTag: 'SNI STANDAR',
        pillClass: 'text-[11px] font-semibold text-orange-700 bg-orange-50 px-2 py-0.5 rounded',
        numClass: 'px-2 py-0.5 rounded bg-orange-100 text-brand-orange font-bold border border-orange-200',
        catClass: 'text-brand-orange font-bold',
        imgAspect: 'aspect-[16/10]',
        imgBorder: 'border border-zinc-200',
        badgeImg: '',
        badgeImgClass: '',
        titleHover: 'group-hover:text-brand-orange',
        descClass: 'text-zinc-600 text-sm leading-relaxed',
        footerBorder: 'border-t border-orange-100',
        footerDot: '',
        footerText: 'STRUKTUR TAHAN GEMPA & KOKOH',
        footerTextColor: 'text-brand-orange',
        arrowBtn: 'text-brand-orange text-sm font-bold group-hover:translate-x-1 transition-transform',
        fallbackImg: 'https://lh3.googleusercontent.com/aida-public/AB6AXuAGmYhYPnJTdHfkC-nmTxBaPR-Yt-qKKuLc_O3BJYMUDN8-OAUFG8_bsFL2fNoMVZxrqCpuM4P_6vBtcQwFsBgEarNtp9roYuihqfniCgn3oVbiwkOG1l1bb_gsidvylHmx4m_ms1ZivT20AmMzPlpLkB8l0ZNpmJlh1wLJGnRK0k5Lj5GAw5Fuegu91V_SAqq9u4d5Invuptgq5n2dNtyP2aGgthACj4bKANr9AC7jEgLvJ331sPvw',
    },
    {
        key: 'manajemen',
        colClass: 'lg:col-span-4 bg-white border-2 border-indigo-200/80 hover:border-indigo-500 p-8 flex flex-col justify-between bento-card shadow-sm group',
        glowClass: '',
        categoryTag: 'MEP & MANAGEMENT',
        pillTag: 'SUPERVISI',
        pillClass: 'text-[11px] font-semibold text-indigo-700 bg-indigo-50 px-2 py-0.5 rounded',
        numClass: 'px-2 py-0.5 rounded bg-indigo-100 text-indigo-700 font-bold border border-indigo-200',
        catClass: 'text-indigo-700 font-bold',
        imgAspect: 'aspect-[16/10]',
        imgBorder: 'border border-zinc-200',
        badgeImg: '',
        badgeImgClass: '',
        titleHover: 'group-hover:text-indigo-600',
        descClass: 'text-zinc-600 text-sm leading-relaxed',
        footerBorder: 'border-t border-indigo-100',
        footerDot: '',
        footerText: 'SISTEM MEKANIKAL & ELEKTRIKAL',
        footerTextColor: 'text-indigo-700',
        arrowBtn: 'text-indigo-600 text-sm font-bold group-hover:translate-x-1 transition-transform',
        fallbackImg: 'https://lh3.googleusercontent.com/aida-public/AB6AXuB2TIxUuiThKwtecbE1ZwJSz0dVHqpkzH7iV2Tgt_5yRHUigKSQUYaWHd0OHBQxHrPsTS-dOQGsg7uNNUXeJcppPVpaQJpgQZLJtT8T7Eg3yZV3YPcTXziO-ph8W-wtqGLCGxJ_qgWc9pN6Is4z93v0qMvahkvYoa-q9Adm_M-ZXxIBv2iSSnagKJgagEM1Nyd75mgSXaNYwyXSzitvF3Iyk_vb0fqXxklxZpa-cxBHFZMVjGkhegnt',
    },
];

// Mengurutkan dan memetakan services dari database dengan tema yang pas
const renderedServices = computed(() => {
    if (!props.services || props.services.length === 0) return [];

    // Prioritaskan urutan seperti di code.html:
    // 1: pemeliharaan
    // 2: lingkungan
    // 3: konsultasi
    // 4: pembangunan
    // 5: manajemen
    const sorted = [...props.services].sort((a, b) => {
        const orderWeight = (s: Service) => {
            const title = (s.title + ' ' + (s.slug ?? '')).toLowerCase();
            if (title.includes('pelihara') || title.includes('perbaikan')) return 1;
            if (title.includes('lingkungan')) return 2;
            if (title.includes('konsultasi') || title.includes('rencana')) return 3;
            if (title.includes('bangun') || title.includes('konstruksi')) return 4;
            if (title.includes('manajemen') || title.includes('mep')) return 5;
            return 10;
        };
        return orderWeight(a) - orderWeight(b);
    });

    return sorted.map((s, index) => {
        const theme = cardThemes[index % cardThemes.length];
        return {
            service: s,
            theme,
            number: String(index + 1).padStart(2, '0'),
        };
    });
});
</script>

<template>
    <section class="py-24 border-b border-zinc-200 bg-white" id="layanan">
        <div class="max-w-[1440px] mx-auto px-6 md:px-10">
            <!-- Section Title & Sub-heading -->
            <div class="flex flex-col lg:flex-row lg:items-end justify-between mb-16 gap-8">
                <div>
                    <span class="text-xs uppercase tracking-widest font-bold text-brand-orange">KOMPETENSI TEKNIS KONTRAKTOR</span>
                    <h2 class="text-4xl sm:text-5xl lg:text-6xl font-display font-extrabold text-zinc-950 mt-3 headline-tight">
                        LAYANAN <br>
                        YANG KAMI <br>
                        <span class="text-brand-orange">KUASAI</span>
                    </h2>
                </div>
                <div class="max-w-md lg:pb-2">
                    <p class="text-zinc-600 text-sm sm:text-base leading-relaxed">
                        Satu tim, satu standar mutu. Setiap layanan ditangani insinyur berpengalaman dengan pelaporan progres yang transparan dan kepatuhan teknik berkelanjutan.
                    </p>
                </div>
            </div>

            <!-- Bento Architectural Grid Layout -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-6">
                <article v-for="item in renderedServices" :key="item.service.id"
                    :class="item.theme.colClass">
                    <div v-if="item.theme.glowClass" :class="item.theme.glowClass"></div>

                    <div class="relative z-10">
                        <div class="flex justify-between items-center text-xs font-mono mb-6 pb-4"
                            :class="item.theme.footerBorder">
                            <div class="flex items-center gap-2.5">
                                <span :class="item.theme.numClass">{{ item.number }}</span>
                                <span :class="item.theme.catClass">{{ item.theme.categoryTag }}</span>
                            </div>
                            <span :class="item.theme.pillClass">{{ item.theme.pillTag }}</span>
                        </div>

                        <div class="mb-6 overflow-hidden w-full rounded-lg relative group"
                            :class="[item.theme.imgAspect, item.theme.imgBorder]">
                            <img :src="item.service.icon || item.theme.fallbackImg" :alt="item.service.title"
                                class="w-full h-full object-cover grayscale contrast-125 group-hover:scale-105 group-hover:grayscale-0 transition-all duration-500" />
                            <div v-if="item.theme.badgeImg"
                                class="absolute bottom-3 left-3 px-3 py-1 backdrop-blur-sm text-[11px] font-mono rounded"
                                :class="item.theme.badgeImgClass">
                                {{ item.theme.badgeImg }}
                            </div>
                        </div>

                        <h3 class="text-2xl sm:text-3xl font-display font-bold mb-3 transition-colors capitalize"
                            :class="[item.theme.titleHover]">
                            {{ item.service.title }}
                        </h3>
                        <p :class="item.theme.descClass">{{ item.service.description }}</p>
                    </div>

                    <div class="pt-6 mt-6 flex items-center justify-between relative z-10"
                        :class="item.theme.footerBorder">
                        <div class="flex items-center gap-2">
                            <span v-if="item.theme.footerDot" :class="item.theme.footerDot"></span>
                            <span class="text-xs uppercase font-bold tracking-widest"
                                :class="item.theme.footerTextColor">
                                {{ item.theme.footerText }}
                            </span>
                        </div>
                        <a href="#kontak" :class="item.theme.arrowBtn">→</a>
                    </div>
                </article>
            </div>
        </div>
    </section>
</template>
