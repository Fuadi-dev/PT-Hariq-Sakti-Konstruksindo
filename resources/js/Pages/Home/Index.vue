<script setup lang="ts">
import { computed, ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import Navbar from '@/Components/Navbar.vue';
import HeroSection from '@/Components/HeroSection.vue';
import BentoServices from '@/Components/BentoServices.vue';

interface ProjectItem {
    id: number;
    title: string;
    slug?: string;
    description?: string | null;
    image?: string | null;
    category?: string | null;
    client_name?: string | null;
    year?: string | number | null;
}

interface PostItem {
    id: number;
    title: string;
    slug: string;
    category?: string | null;
    excerpt?: string | null;
    thumbnail?: string | null;
    published_at?: string | null;
}

interface ServiceItem {
    id: number;
    title: string;
    slug?: string;
    description: string;
    icon?: string | null;
}

interface ClientItem {
    id: number;
    name: string;
    logo?: string | null;
    website_url?: string | null;
}

interface TeamItem {
    id: number;
    name: string;
    position?: string | null;
    photo?: string | null;
    linkedin_url?: string | null;
}

interface SliderItem {
    id: number;
    title: string;
    subtitle?: string | null;
    image: string;
    button_text?: string | null;
    button_url?: string | null;
}

const props = defineProps<{
    company_settings: Record<string, any>;
    sliders: SliderItem[];
    services: ServiceItem[];
    clients: ClientItem[];
    projects: ProjectItem[];
    posts: PostItem[];
    testimonials?: Array<{ id: number; name: string; company?: string; content: string }>;
    teams: TeamItem[];
}>();

// Mobile Navigation Drawer Toggle
const mobileMenuOpen = ref(false);

// Batasi preview proyek di landing page maksimal 3 proyek teratas
const displayedProjects = computed(() => {
    return (props.projects || []).slice(0, 3);
});

// Fallback image untuk spotlight project
const fallbackProjectImage =
    'https://lh3.googleusercontent.com/aida-public/AB6AXuAfEwiLuko-2YvwDp0BFwiGL3YGS3tb0bH3N6Ai6ctt6Qex26ua9RuQ-sE5dFyRoWCnRjY0Y50RsE9E4MNUFO1AHjyg4vwpDdJsYaprCGTBeyoTnPHultE0110XE7rzF-IEMc8_1uZzSpFyaFsKJBlrfQFRBGmVfKLxKEUy6X10Si35S_Edft2NLksomey6JTnhudH2zX-8lZkEIiT72nKMYua45sn5dzORzzX0O-y8FoP5RzSIBkih';



// Styling tema kartu artikel
const postThemes = [
    {
        pillBg: 'bg-blue-100 text-blue-800 border border-blue-200',
        hoverBg: 'hover:bg-blue-50/40',
        border: 'border-blue-200 group-hover:border-blue-500',
        titleHover: 'group-hover:text-blue-600',
        badge1: 'Beton Mutu K-400',
        badge2: 'QC Slump Pass',
        badge2Class: 'bg-emerald-50 text-emerald-700 border border-emerald-200',
        arrowBtn: 'bg-blue-50 text-blue-600 group-hover:bg-blue-600 group-hover:text-white',
        fallbackImg:
            'https://lh3.googleusercontent.com/aida-public/AB6AXuC4dtEZVruqBT2Qw_M5U87qkFXgydBI42jPntv2eSdzbWwOiUSau3as4Cpa4gk1TyP220MtOXXqd41gBJ2J2aGXoc56zSIYUOBxfcfdEzNmvoF2OOd3BZ7S6P-QMvKXIESl9cKkGH7KPgIS8L3om2kNFDkSNoCIziz9aTVDhf1mNYk_Ir5yEfjzNES3rr8uZqIuS9SCv7aFjvmMUC4pWtEsnCTiC6hBlSFsCcycuXcjyur8y8BHIh_r',
    },
    {
        pillBg: 'bg-amber-100 text-amber-800 border border-amber-200',
        hoverBg: 'hover:bg-amber-50/40',
        border: 'border-amber-200 group-hover:border-amber-500',
        titleHover: 'group-hover:text-amber-700',
        badge1: 'NDT Ultrasonic Test',
        badge2: 'Audit Sambungan Las',
        badge2Class: 'bg-amber-50 text-amber-700 border border-amber-200',
        arrowBtn: 'bg-amber-50 text-amber-600 group-hover:bg-amber-600 group-hover:text-white',
        fallbackImg:
            'https://lh3.googleusercontent.com/aida-public/AB6AXuDfzjDJqsQyCokrB9u7a9uAH3qcklUBzeavZdsqBwTkJD5eUihLHSuYZCp0YQnAD9zzKtCxpLUxdieeDk65QeLOhg-W35t2qABGgS-oaYCQykg7tLZSEFeXg7xTfEDINiqIQU9DgwRWi4KvkWEMpQsE8VWe7p0p5NH9JeL6rgDLyrGf2y7y6cBxvE9sq-nHrfw-sg70vf8uhZmI9mrVH-5EhYzONMbcbzztuVmbhc8M-n411X4hr_kS',
    },
    {
        pillBg: 'bg-emerald-100 text-emerald-800 border border-emerald-200',
        hoverBg: 'hover:bg-emerald-50/40',
        border: 'border-emerald-200 group-hover:border-emerald-500',
        titleHover: 'group-hover:text-emerald-700',
        badge1: 'SMK3 Audit Passed',
        badge2: 'Green Construction',
        badge2Class: 'bg-emerald-50 text-emerald-700 border border-emerald-200',
        arrowBtn: 'bg-emerald-50 text-emerald-600 group-hover:bg-emerald-600 group-hover:text-white',
        fallbackImg:
            'https://lh3.googleusercontent.com/aida-public/AB6AXuCjLf1gHZbtgEK4tBwwEW5-SVC1rONIcQ2Gh8X_3kyoR_fDIvuaSLbsV-Au-3GjV6Kxm0z0_Ah-OP_N1-Fx0zJXo-eJq4lALFbB30k0LKVXEzadTyci6oYBEAxnBbLMC1-DCHXtn7tqqyn9ZArhqbmD0AMN-mr3AKzValX_26YygWN4_AoRtfg7h3wlVYg7tjQQcVvcwEo2rYz5vFE1roSO5-G6K2Hw-9Mo1WWwn_byYETNqOm2Xy8j',
    },
];

// Styling kartu tim
const teamThemes = [
    {
        borderClass: 'border-2 border-blue-900/50 hover:border-blue-500',
        tagText: 'DIVISI TEKNIK & QA/QC',
        tagClass: 'bg-blue-900/90 text-blue-200 border border-blue-400',
        titleHover: 'group-hover:text-blue-400',
        badgeText: 'LEADERSHIP',
        badgeClass: 'bg-blue-500/20 text-blue-300 border border-blue-500/30',
        bio: 'Insinyur Sipil, Manajer Proyek, dan Perencana Struktur berlisensi SKA Utama dengan jam terbang lebih dari 15 tahun.',
        skills: [
            { text: 'SKA UTAMA STRUKTUR', class: 'text-blue-300 border-blue-500/30' },
            { text: 'SERTIFIKASI PII', class: 'text-blue-300 border-blue-500/30' },
            { text: 'AUDITOR ISO 9001', class: 'text-emerald-400 border-emerald-500/30' },
        ],
        fallbackPhoto:
            'https://lh3.googleusercontent.com/aida-public/AB6AXuClQ0zIRyw60WVodmUKFHTB72Y78pb_lliCTPIF18qzEw_Y6_Du_fd208giImdW_5yZQcre3rS6e31WbVrBoI7JLvuEsYRNip4fXBEFM7cyC_TytOzEfV_6gCgk79p6XS-Kw87Bz7CYWIlrGmaMy17_XMUTwtk-Aau1fFTZmqnf_Lq2vISzeqjYV09LTh7y4wkgvRof3kDN1h_N-79JgOaI4pYCiCgPMqAiE1nXr8FDsPoqQ90-rAtO',
    },
    {
        borderClass: 'border-2 border-amber-900/50 hover:border-amber-500',
        tagText: 'DIVISI OPERASIONAL K3',
        tagClass: 'bg-amber-900/90 text-amber-200 border border-amber-400',
        titleHover: 'group-hover:text-amber-400',
        badgeText: 'SITE EXECUTION',
        badgeClass: 'bg-amber-500/20 text-amber-300 border border-amber-500/30',
        bio: 'Mandor utama, juru ukur (surveyor) berpresisi milimeter, ahli K3 bersertifikat BNSP, dan teknisi MEP berpengalaman.',
        skills: [
            { text: 'AHLI K3 KONSTRUKSI BNSP', class: 'text-amber-300 border-amber-500/30' },
            { text: 'SURVEYOR TOTAL STATION', class: 'text-amber-300 border-amber-500/30' },
            { text: 'MEP SPECIALIST', class: 'text-orange-400 border-orange-500/30' },
        ],
        fallbackPhoto:
            'https://lh3.googleusercontent.com/aida-public/AB6AXuCQt0GH88dk6mpkqVkhvCttot5k4dtc0uO7e3CG22RgqK-jSGQIgH1CBxTKDseNQbmZaVp4V7ne_aljgKUH25da00WOpDQRv_3NTmPlwPX3ceKSTVr9NwTFP3Gwhmm-teDlwb3pnLzvUJhPpiJnbirdA6Alq-wm-NR7T2GgeAsB9HwKPKvGCnTk0oR8Y2JZry7gYcp68AlAB278ybVyyPQCaRvmYesJmYavN2Zqe9eFaFLCqZbHFgPE',
    },
    {
        borderClass: 'border-2 border-emerald-900/50 hover:border-emerald-500',
        tagText: 'DIVISI ESTIMASI & TENDER',
        tagClass: 'bg-emerald-900/90 text-emerald-200 border border-emerald-400',
        titleHover: 'group-hover:text-emerald-400',
        badgeText: 'COST & PLANNING',
        badgeClass: 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30',
        bio: 'Quantity Surveyor (QS) senior, perencana RAB akurat, serta spesialis negosiasi rantai pasok material konstruksi.',
        skills: [
            { text: 'AHLI QS NASIONAL', class: 'text-emerald-300 border-emerald-500/30' },
            { text: 'BIM 5D COST ESTIMATOR', class: 'text-emerald-300 border-emerald-500/30' },
            { text: 'PROCUREMENT EXPERT', class: 'text-blue-400 border-blue-500/30' },
        ],
        fallbackPhoto: '',
    },
];

// Form Kontak
const form = useForm({
    name: '',
    company: '',
    service_id: props.services?.[0]?.id ?? null,
    message: '',
});

const submit = () => {
    form.post('/contact', {
        preserveScroll: true,
        onSuccess: () => form.reset(),
    });
};
</script>

<template>
    <Head :title="company_settings?.company_name ?? 'PT. Hariq Sakti Konstruksindo — General Contractor & MEP'">
        <meta name="description" :content="company_settings?.tagline ?? 'Kontraktor sipil dan struktur terpercaya.'" />
    </Head>

    <div class="bg-white text-zinc-900 selection:bg-orange-500 selection:text-white">
        <!-- BEGIN: MainHeader -->
        <Navbar :company-settings="company_settings" />
        <!-- END: MainHeader -->

        <!-- BEGIN: HeroSection -->
        <HeroSection :settings="company_settings" :projects="projects" :sliders="sliders" />
        <!-- END: HeroSection -->

        <!-- Klien (Marquee) -->
        <section class="relative overflow-hidden border-b border-zinc-200 py-10 bg-zinc-50 flex flex-col justify-center gap-5">
            <div class="max-w-[1440px] mx-auto px-6 md:px-10 w-full flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-2.5">
                    <span class="w-2.5 h-2.5 rounded-full bg-brand-orange animate-pulse"></span>
                    <span class="text-xs font-mono tracking-widest uppercase text-zinc-600 font-bold">
                        DIPERCAYA OLEH KORPORASI & MITRA STRATEGIS TERKEMUKA
                    </span>
                </div>
                <span class="text-xs font-mono text-zinc-400 hidden sm:inline-block">
                    KOLABORASI BERKELANJUTAN & MUTU TERJAMIN
                </span>
            </div>

            <!-- Fade edges agar ujung layarnya memudar halus -->
            <div class="relative w-full overflow-hidden flex items-center">
                <div class="pointer-events-none absolute inset-y-0 left-0 z-10 w-20 md:w-40 bg-gradient-to-r from-zinc-50 to-transparent"></div>
                <div class="pointer-events-none absolute inset-y-0 right-0 z-10 w-20 md:w-40 bg-gradient-to-l from-zinc-50 to-transparent"></div>
                
                <div class="flex w-max animate-marquee items-center gap-8 pl-8 hover:[animation-play-state:paused]">
                    <template v-for="n in 8" :key="n">
                        <template v-for="c in clients" :key="`${n}-${c.id}`">
                            <div v-if="c.logo"
                                class="h-16 px-6 py-2.5 bg-white rounded-xl border border-zinc-200/90 shadow-sm flex items-center justify-center transition-all duration-300 hover:scale-105 hover:shadow-md hover:border-brand-orange/40 flex-shrink-0">
                                <img :src="c.logo" :alt="c.name"
                                    class="h-9 w-auto max-w-[140px] object-contain transition-transform duration-300" />
                            </div>
                            <div v-else
                                class="h-16 px-6 py-2.5 rounded-xl bg-white border border-zinc-200/90 shadow-sm flex items-center justify-center text-sm font-display font-bold text-zinc-800 tracking-wider uppercase hover:border-brand-orange hover:text-brand-orange transition-colors flex-shrink-0">
                                {{ c.name }}
                            </div>
                        </template>
                    </template>
                </div>
            </div>
        </section>
        <!-- END: Klien (Marquee) -->

        <!-- BEGIN: ServicesSection -->
        <BentoServices :services="services" @select-service="(id: number) => { form.service_id = id; }" />
        <!-- END: ServicesSection -->

        <!-- BEGIN: PortfolioSection -->
        <section class="py-24 border-b border-zinc-200 bg-zinc-50" id="proyek">
            <div class="max-w-[1440px] mx-auto px-6 md:px-10">
                <!-- Section Header -->
                <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-6">
                    <div>
                        <span class="text-xs uppercase tracking-widest font-bold text-orange-600 font-mono">DOKUMENTASI REKAM JEJAK</span>
                        <h2 class="text-4xl sm:text-5xl lg:text-6xl font-display font-extrabold text-zinc-950 mt-3 headline-tight">
                            PROYEK <br>
                            KAMI
                        </h2>
                    </div>
                    <div class="max-w-md lg:pb-2">
                        <p class="text-zinc-600 text-sm sm:text-base leading-relaxed">
                            Dedikasi presisi struktur sipil, arsitektural, dan MEP pada berbagai sektor pembangunan dengan standar mutu dan keselamatan kerja tinggi.
                        </p>
                    </div>
                </div>

                <!-- Projects Grid: 3 Clean Cards (Matching Layanan & Artikel) -->
                <div v-if="displayedProjects.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <article
                        v-for="(p, idx) in displayedProjects"
                        :key="p.id"
                        class="group bg-white border border-zinc-200 rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between hover:-translate-y-1.5 hover:border-orange-500/60"
                    >
                        <div>
                            <!-- Project Image (FULL COLOR, ZERO GRAYSCALE) -->
                            <div class="aspect-[16/10] overflow-hidden bg-zinc-100 relative">
                                <img
                                    :src="p.image || fallbackProjectImage"
                                    :alt="p.title"
                                    class="w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-105"
                                />
                                <!-- Badges on Image -->
                                <div class="absolute top-3 left-3 flex items-center gap-2">
                                    <span class="px-2.5 py-1 text-[11px] font-mono font-bold rounded-md bg-zinc-950/85 text-white backdrop-blur-sm shadow-sm">
                                        0{{ idx + 1 }}
                                    </span>
                                    <span v-if="p.year" class="px-2.5 py-1 text-[10px] font-mono font-bold rounded-md bg-orange-600 text-white shadow-sm">
                                        SELESAI {{ p.year }}
                                    </span>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="p-6 sm:p-7">
                                <span v-if="p.client_name" class="text-xs font-mono uppercase text-orange-600 font-bold block mb-2">
                                    {{ p.client_name }}
                                </span>
                                <h3 class="text-xl sm:text-2xl font-display font-bold text-zinc-950 group-hover:text-orange-600 transition-colors leading-snug mb-3 capitalize">
                                    {{ p.title }}
                                </h3>
                                <p class="text-xs sm:text-sm text-zinc-600 leading-relaxed line-clamp-3">
                                    {{ p.description }}
                                </p>
                            </div>
                        </div>

                        <!-- Card Footer -->
                        <div class="p-6 sm:p-7 pt-0 mt-auto">
                            <div class="pt-4 border-t border-zinc-100 flex items-center justify-between">
                                <a
                                    href="#kontak"
                                    class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-orange-600 hover:text-zinc-950 transition-colors"
                                >
                                    <span>Konsultasi Proyek Serupa</span>
                                    <span class="transition-transform group-hover:translate-x-1">&rarr;</span>
                                </a>
                            </div>
                        </div>
                    </article>
                </div>

                <!-- Empty State (Jika belum ada data sama sekali) -->
                <div v-else class="text-center py-16 bg-white border border-zinc-200 rounded-2xl p-8">
                    <p class="text-zinc-500 text-sm">Belum ada dokumentasi proyek yang dipublikasikan.</p>
                </div>

                <!-- CTA: Lihat Semua Proyek -->
                <div class="mt-14 pt-8 border-t border-zinc-200 flex flex-col sm:flex-row items-center justify-between gap-6 bg-white p-6 md:p-8 rounded-2xl border border-zinc-200/80 shadow-sm">
                    <div>
                        <span class="text-[11px] font-mono font-bold uppercase tracking-wider text-orange-600">DOKUMENTASI LENGKAP</span>
                        <h3 class="text-xl sm:text-2xl font-display font-bold text-zinc-950 mt-1">
                            Jelajahi Seluruh Portofolio Proyek
                        </h3>
                        <p class="text-zinc-600 text-sm mt-1 max-w-xl">
                            Temukan studi kasus komprehensif, spesifikasi teknis bangunan, dan rekam jejak pekerjaan kami di berbagai wilayah.
                        </p>
                    </div>
                    <Link href="/proyek"
                        class="inline-flex items-center gap-3 px-7 py-4 bg-zinc-950 hover:bg-orange-600 text-white font-display font-bold text-xs uppercase tracking-wider rounded-xl transition-all duration-300 shadow-md hover:shadow-xl group flex-shrink-0">
                        <span>LIHAT SEMUA PROYEK</span>
                        <span class="text-base group-hover:translate-x-1 transition-transform">→</span>
                    </Link>
                </div>
            </div>
        </section>
        <!-- END: PortfolioSection -->

        <!-- BEGIN: FieldNotesSection (Artikel) -->
        <section class="py-24 border-b border-zinc-200 bg-white" id="artikel">
            <div class="max-w-[1440px] mx-auto px-6 md:px-10">
                <!-- Section Header -->
                <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-6">
                    <div>
                        <span class="text-xs uppercase tracking-widest font-bold text-brand-orange font-mono">PUBLIKASI & INSIGHT RESMI</span>
                        <h2 class="text-4xl sm:text-5xl lg:text-6xl font-display font-extrabold text-zinc-950 mt-2">
                            ARTIKEL KAMI
                        </h2>
                    </div>
                    <div class="max-w-md">
                        <p class="text-zinc-600 text-sm leading-relaxed">
                            Wawasan teknis konstruksi sipil, metode arsitektural, standar audit mutu K3, dan berita terbaru dari tim profesional kami.
                        </p>
                    </div>
                </div>

                <!-- Articles Ledger Table List -->
                <div class="border-t border-zinc-900">
                    <article v-for="(post, idx) in (posts || []).slice(0, 3)" :key="post.id"
                        class="group py-8 border-b border-zinc-200 flex flex-col md:flex-row items-start md:items-center justify-between gap-6 transition-colors px-3 rounded-lg"
                        :class="postThemes[idx % postThemes.length].hoverBg">
                        <!-- Date & Category -->
                        <div class="flex flex-col gap-1 w-32 flex-shrink-0">
                            <span v-if="post.category" class="px-2.5 py-1 text-[11px] font-mono font-bold rounded w-fit uppercase"
                                :class="postThemes[idx % postThemes.length].pillBg">
                                {{ post.category }}
                            </span>
                            <span class="text-xs font-mono font-medium text-zinc-500">
                                {{ post.published_at || 'Terbaru' }}
                            </span>
                        </div>

                        <!-- Thumbnail (Full Color, No Grayscale) -->
                        <Link :href="`/artikel/${post.slug}`" class="w-24 h-20 flex-shrink-0 overflow-hidden bg-zinc-100 border-2 rounded transition-colors block"
                            :class="postThemes[idx % postThemes.length].border">
                            <img :src="post.thumbnail || postThemes[idx % postThemes.length].fallbackImg"
                                :alt="post.title"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300" />
                        </Link>

                        <!-- Title and Specs -->
                        <div class="flex-grow max-w-xl">
                            <Link :href="`/artikel/${post.slug}`">
                                <h3 class="text-lg md:text-xl font-display font-bold text-zinc-950 transition-colors"
                                    :class="postThemes[idx % postThemes.length].titleHover">
                                    {{ post.title }}
                                </h3>
                            </Link>
                        </div>

                        <!-- Excerpt -->
                        <div class="max-w-md text-xs text-zinc-600 line-clamp-2 md:line-clamp-none">
                            {{ post.excerpt }}
                        </div>

                        <!-- Action Arrow Button -->
                        <Link :href="`/artikel/${post.slug}`"
                            class="w-9 h-9 rounded-full flex items-center justify-center font-bold text-base transition-all flex-shrink-0"
                            :class="postThemes[idx % postThemes.length].arrowBtn">
                            →
                        </Link>
                    </article>
                </div>

                <!-- CTA: Lihat Semua Artikel -->
                <div class="mt-14 pt-8 border-t border-zinc-200 flex flex-col sm:flex-row items-center justify-between gap-6 bg-zinc-50 p-6 md:p-8 rounded-2xl border border-zinc-200">
                    <div>
                        <span class="text-[11px] font-mono font-bold uppercase tracking-wider text-brand-orange">ARSIP LENGKAP</span>
                        <h3 class="text-xl sm:text-2xl font-display font-bold text-zinc-950 mt-1">
                            Ingin Membaca Artikel Lainnya?
                        </h3>
                        <p class="text-zinc-600 text-sm mt-1 max-w-xl">
                            Pelajari metode konstruksi sipil, standar audit mutu K3, dan analisis teknologi teknik terbaru kami.
                        </p>
                    </div>
                    <Link href="/artikel"
                        class="inline-flex items-center gap-3 px-7 py-4 bg-brand-orange hover:bg-zinc-950 text-white font-display font-bold text-xs uppercase tracking-wider rounded-xl transition-all duration-300 shadow-md hover:shadow-xl group flex-shrink-0">
                        <span>LIHAT SEMUA ARTIKEL</span>
                        <span class="text-base group-hover:translate-x-1 transition-transform">→</span>
                    </Link>
                </div>
            </div>
        </section>
        <!-- END: FieldNotesSection -->

        <!-- BEGIN: TeamSection -->
        <section class="py-24 bg-brand-dark text-white border-b border-zinc-800" id="tim">
            <div class="max-w-[1440px] mx-auto px-6 md:px-10">
                <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-6">
                    <div>
                        <span class="text-xs uppercase tracking-widest font-bold text-brand-orange">SUMBER DAYA MANUSIA</span>
                        <h2 class="text-4xl sm:text-5xl lg:text-6xl font-display font-extrabold text-white mt-2">
                            TIM KAMI
                        </h2>
                    </div>
                    <p class="text-zinc-400 text-sm max-w-md leading-relaxed">
                        Digerakkan oleh para ahli dengan rekam jejak puluhan tahun di industri konstruksi struktur sipil dan MEP.
                    </p>
                </div>

                <!-- Team Members Showcase Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-12">
                    <div v-for="(t, idx) in (teams || []).slice(0, 4)" :key="t.id"
                        class="p-6 md:p-8 bg-zinc-900/80 rounded-lg transition-all shadow-lg group"
                        :class="teamThemes[idx % teamThemes.length].borderClass">
                        <!-- Photo Frame (Full Color, No Grayscale) -->
                        <div class="aspect-[4/3] w-full overflow-hidden bg-zinc-950 mb-6 border border-zinc-800 rounded relative">
                            <img :src="t.photo || teamThemes[idx % teamThemes.length].fallbackPhoto"
                                :alt="t.name"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                            <div class="absolute top-3 right-3 px-2.5 py-1 text-[10px] font-mono font-bold rounded"
                                :class="teamThemes[idx % teamThemes.length].tagClass">
                                {{ teamThemes[idx % teamThemes.length].tagText }}
                            </div>
                        </div>

                        <!-- Header Info -->
                        <div class="flex items-center justify-between">
                            <h3 class="text-xl font-display font-bold uppercase tracking-wider text-white transition-colors"
                                :class="teamThemes[idx % teamThemes.length].titleHover">
                                {{ t.name }}
                            </h3>
                            <span class="text-xs font-mono px-2 py-0.5 rounded font-semibold"
                                :class="teamThemes[idx % teamThemes.length].badgeClass">
                                {{ teamThemes[idx % teamThemes.length].badgeText }}
                            </span>
                        </div>

                        <!-- Bio / Description -->
                        <p class="text-xs text-zinc-300 mt-2">
                            {{ t.position ? t.position : teamThemes[idx % teamThemes.length].bio }}
                        </p>

                        <!-- Skill Tags -->
                        <div class="flex flex-wrap gap-2 mt-4 pt-3 border-t border-zinc-800">
                            <span v-for="skill in teamThemes[idx % teamThemes.length].skills" :key="skill.text"
                                class="px-2 py-0.5 rounded bg-zinc-800 text-[10px] font-mono border"
                                :class="skill.class">
                                {{ skill.text }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- END: TeamSection -->

        <!-- BEGIN: ContactSection -->
        <section class="py-24 bg-white border-b border-zinc-200" id="kontak">
            <div class="max-w-[1440px] mx-auto px-6 md:px-10">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-start">
                    <!-- Left: Statement and Coordinates -->
                    <div class="lg:col-span-5 space-y-8">
                        <div>
                            <span class="text-xs uppercase tracking-widest font-bold text-brand-orange font-mono">MULAI KOLABORASI</span>
                            <h2 class="text-4xl sm:text-5xl xl:text-6xl font-display font-extrabold text-zinc-950 mt-3 headline-tight">
                                PUNYA <br>
                                PROYEK? <br>
                                <span class="text-brand-orange">MARI BICARA.</span>
                            </h2>
                            <p class="text-zinc-600 text-sm sm:text-base leading-relaxed mt-6">
                                Ceritakan kebutuhan Anda. Tim estimasi dan engineer kami akan meninjau spesifikasi dan merespons melalui WhatsApp dalam satu hari kerja.
                            </p>
                        </div>

                        <!-- Direct Communication Channels -->
                        <div class="space-y-4 pt-4 border-t border-zinc-200 text-sm">
                            <div class="p-3 rounded-lg bg-blue-50 border border-blue-200">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                                    <p class="text-xs uppercase font-bold text-blue-900">Kantor Pusat & Workshop:</p>
                                </div>
                                <p class="font-medium text-zinc-900 text-xs sm:text-sm">
                                    {{ company_settings?.address ?? 'Gedung Konstruksindo Center, Jl. Jend. Sudirman Kav. 52-53, Jakarta Selatan' }}
                                </p>
                            </div>

                            <div class="p-3 rounded-lg bg-amber-50 border border-amber-200">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="w-2 h-2 rounded-full bg-amber-600"></span>
                                    <p class="text-xs uppercase font-bold text-amber-900">Email Penawaran & Tender:</p>
                                </div>
                                <p class="font-medium text-zinc-900 text-xs sm:text-sm font-mono">
                                    {{ company_settings?.email ?? 'proyek@hariqsakti.co.id' }}
                                </p>
                            </div>

                            <div class="p-3 rounded-lg bg-emerald-50 border border-emerald-200">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="w-2 h-2 rounded-full bg-emerald-600 animate-pulse"></span>
                                    <p class="text-xs uppercase font-bold text-emerald-900">Hotline WhatsApp & Estimasi Cepat:</p>
                                </div>
                                <p class="font-bold text-emerald-800 text-xs sm:text-sm font-mono">
                                    {{ company_settings?.whatsapp ?? '+62 812-8899-2026 / +62 21-5544-3210' }}
                                </p>
                                <span class="text-[11px] text-emerald-700 font-medium block mt-0.5">Respon dalam 1 Jam Kerja</span>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Inquiry Form Matching Snapshot -->
                    <div class="lg:col-span-7 bg-zinc-50 border border-zinc-200 p-8 sm:p-12">
                        <form @submit.prevent="submit" class="space-y-8">
                            <!-- Field: Nama Lengkap -->
                            <div class="border-b border-zinc-300 pb-2 focus-within:border-brand-orange transition-colors">
                                <label class="block text-xs uppercase font-bold tracking-wider text-zinc-500 mb-2" for="nama">
                                    Nama Anda
                                </label>
                                <input v-model="form.name"
                                    class="w-full bg-transparent border-0 p-0 text-zinc-900 placeholder:text-zinc-400 focus:ring-0 text-base font-medium"
                                    id="nama" name="nama" placeholder="Contoh: Budi Santoso" required type="text" />
                                <p v-if="form.errors.name" class="mt-1 text-sm text-red-600">{{ form.errors.name }}</p>
                            </div>

                            <!-- Field: Nama Perusahaan -->
                            <div class="border-b border-zinc-300 pb-2 focus-within:border-brand-orange transition-colors">
                                <label class="block text-xs uppercase font-bold tracking-wider text-zinc-500 mb-2" for="perusahaan">
                                    Perusahaan / Instansi
                                </label>
                                <input v-model="form.company"
                                    class="w-full bg-transparent border-0 p-0 text-zinc-900 placeholder:text-zinc-400 focus:ring-0 text-base font-medium"
                                    id="perusahaan" name="perusahaan" placeholder="Contoh: PT Bangun Bersama Sejahtera" type="text" />
                                <p v-if="form.errors.company" class="mt-1 text-sm text-red-600">{{ form.errors.company }}</p>
                            </div>

                            <!-- Field: Jenis Layanan -->
                            <div class="border-b border-zinc-300 pb-2 focus-within:border-brand-orange transition-colors">
                                <label class="block text-xs uppercase font-bold tracking-wider text-zinc-500 mb-2" for="layanan-select">
                                    Jenis Layanan
                                </label>
                                <select v-model="form.service_id"
                                    class="w-full bg-transparent border-0 p-0 text-zinc-900 focus:ring-0 text-base font-medium capitalize cursor-pointer"
                                    id="layanan-select" name="service_id">
                                    <option v-for="s in services" :key="s.id" :value="s.id" class="text-zinc-900 capitalize">
                                        {{ s.title }}
                                    </option>
                                </select>
                                <p v-if="form.errors.service_id" class="mt-1 text-sm text-red-600">{{ form.errors.service_id }}</p>
                            </div>

                            <!-- Field: Detail Proyek -->
                            <div class="border-b border-zinc-300 pb-2 focus-within:border-brand-orange transition-colors">
                                <label class="block text-xs uppercase font-bold tracking-wider text-zinc-500 mb-2" for="pesan">
                                    Ceritakan Proyek Anda
                                </label>
                                <textarea v-model="form.message"
                                    class="w-full bg-transparent border-0 p-0 text-zinc-900 placeholder:text-zinc-400 focus:ring-0 text-base font-medium resize-none"
                                    id="pesan" name="pesan" placeholder="Lokasi lahan, perkiraan luas, target waktu pengerjaan..." required rows="4"></textarea>
                                <p v-if="form.errors.message" class="mt-1 text-sm text-red-600">{{ form.errors.message }}</p>
                            </div>

                            <!-- Submit Button -->
                            <div>
                                <button type="submit" :disabled="form.processing"
                                    class="w-full sm:w-auto inline-flex items-center justify-center gap-3 bg-zinc-950 text-white px-8 py-4 text-xs font-bold uppercase tracking-wider hover:bg-brand-orange transition-colors disabled:opacity-50">
                                    <span>{{ form.processing ? 'MENGHUBUNGKAN...' : 'KIRIM VIA WHATSAPP' }}</span>
                                    <span class="text-base">→</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <!-- END: ContactSection -->

        <!-- BEGIN: MainFooter -->
        <footer class="bg-white py-12 border-t border-zinc-200">
            <div class="max-w-[1440px] mx-auto px-6 md:px-10 flex flex-col md:flex-row items-center justify-between gap-6 text-xs text-zinc-500">
                <!-- Company Copyright -->
                <div>
                    <p>© {{ new Date().getFullYear() }} {{ company_settings?.company_name ?? 'PT. Hariq Sakti Konstruksindo' }}. Hak Cipta Dilindungi Undang-Undang.</p>
                </div>

                <!-- Quick Footer Links -->
                <div class="flex flex-wrap items-center gap-6 font-semibold uppercase tracking-wider text-zinc-700">
                    <a class="hover:text-brand-orange transition-colors" href="#layanan">Layanan</a>
                    <a class="hover:text-brand-orange transition-colors" href="#proyek">Proyek</a>
                    <a class="hover:text-brand-orange transition-colors" href="#artikel">Artikel</a>
                    <a class="hover:text-brand-orange transition-colors" href="#tim">Tim Ahli</a>
                    <a class="hover:text-brand-orange transition-colors" href="#kontak">Kontak</a>
                </div>
            </div>
        </footer>
        <!-- END: MainFooter -->
    </div>
</template>
