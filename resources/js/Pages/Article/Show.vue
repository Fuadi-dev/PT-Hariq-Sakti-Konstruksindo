<script setup lang="ts">
import { ref } from 'vue';
import { Head, Link } from '@inertiajs/vue3';

interface PostDetail {
    id: number;
    title: string;
    slug: string;
    content: string | null;
    thumbnail: string | null;
    category: string;
    author: string;
    published_at: string | null;
    read_time: string;
}

interface RelatedPost {
    id: number;
    title: string;
    slug: string;
    category?: string | null;
    excerpt?: string | null;
    thumbnail?: string | null;
    published_at?: string | null;
}

const props = defineProps<{
    company_settings: Record<string, any>;
    post: PostDetail;
    related_posts: RelatedPost[];
}>();

// Mobile navigation drawer toggle
const mobileMenuOpen = ref(false);

// Salin link feedback state
const linkCopied = ref(false);
const copyCurrentUrl = () => {
    if (typeof window !== 'undefined') {
        navigator.clipboard.writeText(window.location.href);
        linkCopied.value = true;
        setTimeout(() => {
            linkCopied.value = false;
        }, 3000);
    }
};

// Fallback gambar artikel jika thumbnail kosong
const fallbackArticleImg =
    'https://lh3.googleusercontent.com/aida-public/AB6AXuC4dtEZVruqBT2Qw_M5U87qkFXgydBI42jPntv2eSdzbWwOiUSau3as4Cpa4gk1TyP220MtOXXqd41gBJ2J2aGXoc56zSIYUOBxfcfdEzNmvoF2OOd3BZ7S6P-QMvKXIESl9cKkGH7KPgIS8L3om2kNFDkSNoCIziz9aTVDhf1mNYk_Ir5yEfjzNES3rr8uZqIuS9SCv7aFjvmMUC4pWtEsnCTiC6hBlSFsCcycuXcjyur8y8BHIh_r';

const whatsappShareUrl = () => {
    if (typeof window !== 'undefined') {
        const text = `Baca catatan lapangan "${props.post.title}" dari PT Hariq Sakti Konstruksindo: ${window.location.href}`;
        return `https://wa.me/?text=${encodeURIComponent(text)}`;
    }
    return '#';
};
</script>

<template>
    <Head :title="`${post.title} — PT. Hariq Sakti Konstruksindo`">
        <meta name="description" :content="post.title" />
    </Head>

    <div class="bg-white text-zinc-900 selection:bg-orange-500 selection:text-white min-h-screen flex flex-col justify-between">
        <!-- BEGIN: MainHeader -->
        <header class="sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b border-zinc-200">
            <div class="max-w-[1440px] mx-auto px-6 md:px-10 h-20 flex items-center justify-between">
                <!-- Company Brand Identity -->
                <a aria-label="Beranda PT Hariq Sakti Konstruksindo" class="flex items-center group" href="/">
                    <img src="/img/logo.jpeg" alt="PT. Hariq Sakti Konstruksindo" class="h-10 sm:h-12 w-auto object-contain transition-transform duration-300 group-hover:scale-105" />
                </a>

                <!-- Primary Navigation Links -->
                <nav aria-label="Navigasi Utama" class="hidden md:flex items-center gap-8 lg:gap-10 text-xs font-bold tracking-wider uppercase text-zinc-800">
                    <a class="hover:text-brand-orange transition-colors" href="/#layanan">LAYANAN</a>
                    <a class="hover:text-brand-orange transition-colors" href="/#proyek">PROYEK</a>
                    <a class="text-brand-orange transition-colors" href="/#artikel">ARTIKEL</a>
                    <a class="hover:text-brand-orange transition-colors" href="/#tim">TIM</a>
                    <a class="hover:text-brand-orange transition-colors" href="/#kontak">KONTAK</a>
                </nav>

                <!-- Action Consultation Button & Mobile Toggle -->
                <div class="flex items-center gap-4">
                    <a class="hidden sm:inline-flex items-center justify-center text-xs font-bold uppercase tracking-wider px-5 py-3 border border-zinc-900 hover:bg-zinc-900 hover:text-white transition-all duration-200" href="/#kontak">
                        KONSULTASI GRATIS
                    </a>
                    <button @click="mobileMenuOpen = !mobileMenuOpen" aria-label="Buka Menu" class="inline-flex md:hidden p-2 text-zinc-900 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path v-if="!mobileMenuOpen" d="M4 6h16M4 12h16m-7 6h7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                            <path v-else d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Nav Dropdown -->
            <div v-if="mobileMenuOpen" class="md:hidden border-b border-zinc-200 bg-white px-6 py-5 flex flex-col gap-4 text-xs font-bold tracking-wider uppercase shadow-md">
                <a @click="mobileMenuOpen = false" class="hover:text-brand-orange py-1" href="/#layanan">LAYANAN</a>
                <a @click="mobileMenuOpen = false" class="hover:text-brand-orange py-1" href="/#proyek">PROYEK</a>
                <a @click="mobileMenuOpen = false" class="text-brand-orange py-1" href="/#artikel">ARTIKEL</a>
                <a @click="mobileMenuOpen = false" class="hover:text-brand-orange py-1" href="/#tim">TIM</a>
                <a @click="mobileMenuOpen = false" class="hover:text-brand-orange py-1" href="/#kontak">KONTAK</a>
                <a @click="mobileMenuOpen = false" class="inline-flex items-center justify-center text-xs font-bold uppercase tracking-wider px-5 py-3 bg-zinc-950 text-white mt-2" href="/#kontak">
                    KONSULTASI GRATIS
                </a>
            </div>
        </header>
        <!-- END: MainHeader -->

        <main class="flex-grow">
            <!-- Article Header Section -->
            <section class="border-b border-zinc-200 bg-zinc-50/60 py-12 md:py-16">
                <div class="max-w-[1100px] mx-auto px-6 md:px-10">
                    <!-- Breadcrumbs -->
                    <nav class="flex items-center gap-2 text-xs font-mono text-zinc-500 uppercase tracking-wider mb-8">
                        <a href="/" class="hover:text-brand-orange transition-colors">Beranda</a>
                        <span>/</span>
                        <a href="/#artikel" class="hover:text-brand-orange transition-colors">Catatan Lapangan</a>
                        <span>/</span>
                        <span class="text-zinc-900 font-bold truncate max-w-[200px] sm:max-w-md">{{ post.title }}</span>
                    </nav>

                    <!-- Article Meta Badges -->
                    <div class="flex flex-wrap items-center gap-3 mb-6">
                        <span class="px-3 py-1 rounded bg-orange-100 text-brand-orange font-bold text-xs uppercase tracking-wider border border-orange-200 font-mono">
                            {{ post.category }}
                        </span>
                        <span class="text-zinc-400 font-mono text-xs">•</span>
                        <span class="text-xs font-mono font-medium text-zinc-600">
                            {{ post.published_at || 'Terbaru' }}
                        </span>
                        <span class="text-zinc-400 font-mono text-xs">•</span>
                        <span class="text-xs font-mono text-zinc-500 bg-zinc-100 px-2 py-0.5 rounded">
                            {{ post.read_time }}
                        </span>
                    </div>

                    <!-- Master Headline -->
                    <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-zinc-950 font-display leading-[1.1] tracking-tight mb-8">
                        {{ post.title }}
                    </h1>

                    <!-- Author Info Strip -->
                    <div class="flex items-center gap-3 pt-6 border-t border-zinc-200 text-xs text-zinc-600">
                        <div class="w-8 h-8 rounded-full bg-zinc-900 text-white flex items-center justify-center font-display font-bold text-xs">
                            HS
                        </div>
                        <div>
                            <p class="font-bold text-zinc-900 uppercase font-display">{{ post.author }}</p>
                            <p class="text-[11px] text-zinc-500">Divisi Quality Control & K3 Lapangan</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Article Main Content & Sidebar -->
            <section class="py-12 md:py-16">
                <div class="max-w-[1100px] mx-auto px-6 md:px-10">
                    <!-- Featured Image Banner -->
                    <div class="overflow-hidden rounded-lg border-2 border-zinc-900 bg-zinc-100 mb-12 shadow-sm relative group">
                        <img :src="post.thumbnail || fallbackArticleImg" :alt="post.title"
                            class="w-full h-[320px] sm:h-[450px] md:h-[520px] object-cover transition-transform duration-700 group-hover:scale-102" />
                        <div class="absolute bottom-4 left-4 right-4 flex items-center justify-between pointer-events-none">
                            <span class="bg-zinc-900/85 backdrop-blur text-white font-mono text-[11px] px-3 py-1.5 rounded uppercase tracking-widest border border-white/10">
                                DOKUMENTASI RESMI SITE PROYEK
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
                        <!-- Main Content (Col 8) -->
                        <div class="lg:col-span-8">
                            <!-- Article Body -->
                            <div class="text-zinc-800 text-base sm:text-lg leading-relaxed space-y-6 article-prose font-normal">
                                <div v-if="post.content" v-html="post.content" class="space-y-6"></div>
                                <div v-else class="space-y-4 text-zinc-600">
                                    <p>
                                        Proses pelaksanaan konstruksi ini dijalankan dengan komitmen penuh pada standar rekayasa sipil modern dan manajemen K3. Setiap tahapan pengawasan material diuji kelayakannya secara independen untuk memastikan durabilitas struktur dalam jangka panjang.
                                    </p>
                                    <p>
                                        Koordinasi harian antara manajer proyek, pengawas lapangan, serta konsultan struktur dilakukan secara berkesinambungan guna memastikan proyek selesai tepat waktu tanpa kompromi pada mutu teknis.
                                    </p>
                                </div>
                            </div>

                            <!-- Share & Action Bar -->
                            <div class="mt-12 pt-8 border-t border-zinc-200 flex flex-wrap items-center justify-between gap-4">
                                <span class="text-xs uppercase font-bold tracking-wider text-zinc-500 font-mono">
                                    BAGIKAN CATATAN LAPANGAN:
                                </span>
                                <div class="flex items-center gap-3">
                                    <a :href="whatsappShareUrl()" target="_blank"
                                        class="inline-flex items-center gap-2 px-4 py-2 rounded bg-emerald-50 text-emerald-700 border border-emerald-200 font-bold text-xs uppercase hover:bg-emerald-600 hover:text-white transition-colors">
                                        WhatsApp
                                    </a>
                                    <button @click="copyCurrentUrl"
                                        class="inline-flex items-center gap-2 px-4 py-2 rounded bg-zinc-100 text-zinc-700 border border-zinc-200 font-bold text-xs uppercase hover:bg-zinc-900 hover:text-white transition-colors">
                                        {{ linkCopied ? 'Tersalin!' : 'Salin Link' }}
                                    </button>
                                </div>
                            </div>

                            <!-- Author Card Sign-off -->
                            <div class="mt-8 p-6 rounded-lg bg-zinc-50 border border-zinc-200 flex flex-col sm:flex-row items-start sm:items-center gap-4">
                                <div class="w-12 h-12 rounded-full bg-brand-orange text-white flex items-center justify-center font-display font-bold text-base flex-shrink-0">
                                    HSK
                                </div>
                                <div class="text-xs text-zinc-600 space-y-1">
                                    <p class="font-bold text-zinc-900 font-display text-sm uppercase">PT Hariq Sakti Konstruksindo</p>
                                    <p class="leading-relaxed">
                                        Laporan catatan lapangan ini disusun oleh tim teknis lapangan. Kami berkomitmen memberikan transparansi progres dan standar keselamatan kerja tertinggi di setiap proyek konstruksi sipil dan struktur.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Sidebar (Col 4) -->
                        <div class="lg:col-span-4 space-y-6">
                            <!-- Consultation Callout Card -->
                            <div class="p-6 md:p-8 rounded-lg bg-zinc-950 text-white border border-zinc-800 shadow-xl space-y-5">
                                <div class="flex items-center gap-2">
                                    <span class="w-2.5 h-2.5 rounded-full bg-brand-orange animate-pulse"></span>
                                    <span class="text-xs font-mono font-bold text-orange-400 uppercase tracking-widest">KONSULTASI STRUKTUR</span>
                                </div>
                                <h3 class="text-xl sm:text-2xl font-display font-bold leading-tight">
                                    Punya Kebutuhan Proyek Serupa?
                                </h3>
                                <p class="text-xs text-zinc-300 leading-relaxed">
                                    Diskusikan rencana anggaran biaya (RAB), jadwal pengerjaan, dan spesifikasi teknis bersama insinyur senior kami.
                                </p>
                                <a href="/#kontak"
                                    class="inline-flex items-center justify-between w-full p-4 bg-brand-orange text-white font-bold text-xs uppercase tracking-wider hover:bg-white hover:text-zinc-950 transition-colors rounded">
                                    <span>HUBUNGI VIA WHATSAPP</span>
                                    <span class="text-base">→</span>
                                </a>
                            </div>

                            <!-- Quality Certification Standards -->
                            <div class="p-6 rounded-lg bg-zinc-50 border border-zinc-200 space-y-4">
                                <h4 class="text-xs font-bold uppercase tracking-wider text-zinc-500 font-mono">
                                    STANDAR & KEPATUHAN MUTU
                                </h4>
                                <ul class="space-y-3 text-xs text-zinc-700">
                                    <li class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-emerald-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path clip-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" fill-rule="evenodd"></path></svg>
                                        <span>Sertifikasi SBU & LPJK Nasional</span>
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-emerald-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path clip-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" fill-rule="evenodd"></path></svg>
                                        <span>Standar K3 / SMK3 Nol Kecelakaan</span>
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-emerald-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path clip-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" fill-rule="evenodd"></path></svg>
                                        <span>ISO 9001:2015 Mutu Terpadu</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Related Articles Section -->
            <section v-if="related_posts && related_posts.length > 0" class="py-16 bg-zinc-50 border-t border-zinc-200">
                <div class="max-w-[1100px] mx-auto px-6 md:px-10">
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <span class="text-xs uppercase tracking-widest font-bold text-brand-orange">DOKUMENTASI LAINNYA</span>
                            <h2 class="text-2xl sm:text-3xl font-display font-extrabold text-zinc-950 mt-1">
                                Catatan Lapangan Terkait
                            </h2>
                        </div>
                        <a href="/#artikel" class="text-xs uppercase font-bold tracking-wider text-zinc-700 hover:text-brand-orange transition-colors">
                            Lihat Semua →
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <article v-for="rel in related_posts" :key="rel.id"
                            class="bg-white border border-zinc-200 rounded-lg overflow-hidden flex flex-col justify-between hover:shadow-lg transition-all duration-300 group">
                            <div>
                                <div class="aspect-[16/10] overflow-hidden bg-zinc-100 relative">
                                    <img :src="rel.thumbnail || fallbackArticleImg" :alt="rel.title"
                                        class="w-full h-full object-cover grayscale contrast-125 group-hover:grayscale-0 group-hover:scale-105 transition-all duration-500" />
                                </div>
                                <div class="p-5">
                                    <div class="flex items-center gap-2 text-xs font-mono text-zinc-500 mb-2">
                                        <span class="text-brand-orange font-bold uppercase">{{ rel.category || 'CIVIL' }}</span>
                                        <span>•</span>
                                        <span>{{ rel.published_at }}</span>
                                    </div>
                                    <h3 class="font-display font-bold text-base text-zinc-950 group-hover:text-brand-orange transition-colors line-clamp-2">
                                        {{ rel.title }}
                                    </h3>
                                    <p class="text-xs text-zinc-600 line-clamp-2 mt-2 leading-relaxed">
                                        {{ rel.excerpt }}
                                    </p>
                                </div>
                            </div>
                            <div class="p-5 pt-0">
                                <a :href="`/artikel/${rel.slug}`"
                                    class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-zinc-900 group-hover:text-brand-orange transition-colors">
                                    <span>BACA SELENGKAPNYA</span>
                                    <span>→</span>
                                </a>
                            </div>
                        </article>
                    </div>
                </div>
            </section>
        </main>

        <!-- BEGIN: MainFooter -->
        <footer class="bg-white py-12 border-t border-zinc-200">
            <div class="max-w-[1440px] mx-auto px-6 md:px-10 flex flex-col md:flex-row items-center justify-between gap-6 text-xs text-zinc-500">
                <!-- Company Copyright -->
                <div>
                    <p>© {{ new Date().getFullYear() }} {{ company_settings?.company_name ?? 'PT. Hariq Sakti Konstruksindo' }}. Hak Cipta Dilindungi Undang-Undang.</p>
                </div>

                <!-- Quick Footer Links -->
                <div class="flex flex-wrap items-center gap-6 font-semibold uppercase tracking-wider text-zinc-700">
                    <a class="hover:text-brand-orange transition-colors" href="/#layanan">Layanan</a>
                    <a class="hover:text-brand-orange transition-colors" href="/#proyek">Proyek</a>
                    <a class="hover:text-brand-orange transition-colors" href="/#artikel">Catatan Lapangan</a>
                    <a class="hover:text-brand-orange transition-colors" href="/#tim">Tim Ahli</a>
                    <a class="hover:text-brand-orange transition-colors" href="/#kontak">Kontak</a>
                </div>
            </div>
        </footer>
        <!-- END: MainFooter -->
    </div>
</template>

<style scoped>
.article-prose :deep(p) {
    margin-bottom: 1.5rem;
    line-height: 1.8;
}
.article-prose :deep(h2) {
    font-family: 'Space Grotesk', sans-serif;
    font-size: 1.75rem;
    font-weight: 700;
    margin-top: 2.5rem;
    margin-bottom: 1rem;
    color: #09090b;
}
.article-prose :deep(h3) {
    font-family: 'Space Grotesk', sans-serif;
    font-size: 1.35rem;
    font-weight: 700;
    margin-top: 2rem;
    margin-bottom: 0.75rem;
    color: #18181b;
}
.article-prose :deep(ul) {
    list-style-type: disc;
    padding-left: 1.5rem;
    margin-bottom: 1.5rem;
}
.article-prose :deep(ol) {
    list-style-type: decimal;
    padding-left: 1.5rem;
    margin-bottom: 1.5rem;
}
.article-prose :deep(li) {
    margin-bottom: 0.5rem;
}
.article-prose :deep(blockquote) {
    border-left: 4px solid #ea580c;
    padding-left: 1.25rem;
    font-style: italic;
    color: #3f3f46;
    margin: 2rem 0;
}
.article-prose :deep(img) {
    border-radius: 0.5rem;
    margin: 2rem 0;
    max-width: 100%;
    height: auto;
}
</style>
