<script setup lang="ts">
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import Navbar from '@/Components/Navbar.vue';

interface PostItem {
    id: number;
    title: string;
    slug: string;
    category?: string | null;
    excerpt?: string | null;
    thumbnail?: string | null;
    published_at?: string | null;
}

interface PaginationLink {
    url: string | null;
    label: string;
    active: boolean;
}

interface PaginatedPosts {
    data: PostItem[];
    links: PaginationLink[];
    current_page: number;
    last_page: number;
    total: number;
}

const props = defineProps<{
    company_settings: Record<string, any>;
    posts: PaginatedPosts;
    filters: {
        q?: string;
    };
}>();

const searchQuery = ref(props.filters.q ?? '');
let debounceTimer: ReturnType<typeof setTimeout> | undefined;

const handleSearch = () => {
    if (debounceTimer) clearTimeout(debounceTimer);
    router.get(
        '/artikel',
        { q: searchQuery.value || undefined },
        {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        }
    );
};

const onSearchInput = () => {
    if (debounceTimer) clearTimeout(debounceTimer);
    debounceTimer = setTimeout(() => {
        handleSearch();
    }, 350);
};

const fallbackArticleImg =
    'https://lh3.googleusercontent.com/aida-public/AB6AXuC4dtEZVruqBT2Qw_M5U87qkFXgydBI42jPntv2eSdzbWwOiUSau3as4Cpa4gk1TyP220MtOXXqd41gBJ2J2aGXoc56zSIYUOBxfcfdEzNmvoF2OOd3BZ7S6P-QMvKXIESl9cKkGH7KPgIS8L3om2kNFDkSNoCIziz9aTVDhf1mNYk_Ir5yEfjzNES3rr8uZqIuS9SCv7aFjvmMUC4pWtEsnCTiC6hBlSFsCcycuXcjyur8y8BHIh_r';
</script>

<template>
    <Head :title="`Artikel & Publikasi Konstruksi — ${company_settings?.company_name ?? 'PT. Hariq Sakti Konstruksindo'}`">
        <meta name="description" content="Kumpulan artikel, publikasi teknik, studi konstruksi, dan insight rekayasa struktur dari PT. Hariq Sakti Konstruksindo." />
    </Head>

    <div class="bg-white text-zinc-900 selection:bg-orange-500 selection:text-white min-h-screen flex flex-col justify-between">
        <!-- MainHeader -->
        <Navbar :company-settings="company_settings" current-page="artikel" />

        <main class="flex-grow pt-20">
            <!-- Header Banner Section -->
            <section class="border-b border-zinc-200 bg-zinc-950 text-white py-14 sm:py-20 relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-r from-orange-950/40 via-transparent to-zinc-950 pointer-events-none"></div>
                <div class="max-w-[1440px] mx-auto px-6 md:px-10 relative z-10">
                    <!-- Breadcrumbs -->
                    <nav class="flex items-center gap-2 text-xs font-mono text-zinc-400 uppercase tracking-wider mb-6">
                        <Link href="/" class="hover:text-orange-400 transition-colors">Beranda</Link>
                        <span>/</span>
                        <span class="text-orange-400 font-bold">Artikel</span>
                    </nav>

                    <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-8">
                        <div>
                            <span class="text-xs uppercase tracking-widest font-mono text-orange-400 font-bold">PUBLIKASI & INSIGHT RESMI</span>
                            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-display font-extrabold text-white mt-3 headline-tight">
                                Artikel <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-400 via-orange-500 to-amber-400">Kami</span>
                            </h1>
                            <p class="text-zinc-300 text-sm sm:text-base max-w-2xl mt-4 leading-relaxed">
                                Dokumentasi teknis, audit mutu material, praktik terbaik K3, dan wawasan rekayasa konstruksi sipil langsung dari tim engineer di lapangan.
                            </p>
                        </div>

                        <!-- Search Bar -->
                        <div class="w-full lg:w-96">
                            <form @submit.prevent="handleSearch" class="relative">
                                <input
                                    v-model="searchQuery"
                                    @input="onSearchInput"
                                    @change="handleSearch"
                                    type="text"
                                    placeholder="Cari artikel, topik, berita..."
                                    class="w-full bg-zinc-900/90 text-white border border-zinc-700 rounded-lg pl-4 pr-24 py-3 text-xs sm:text-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500 placeholder-zinc-500"
                                />
                                <button
                                    type="submit"
                                    class="absolute right-1.5 top-1.5 bottom-1.5 px-4 bg-orange-600 hover:bg-orange-500 text-white text-xs font-bold uppercase tracking-wider rounded transition-colors"
                                >
                                    Cari
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Articles Grid Section -->
            <section class="py-16 sm:py-20 bg-zinc-50/60">
                <div class="max-w-[1440px] mx-auto px-6 md:px-10">
                    <div v-if="posts.data.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        <article
                            v-for="post in posts.data"
                            :key="post.id"
                            class="group bg-white border border-zinc-200 rounded-xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between hover:-translate-y-1"
                        >
                            <!-- Thumbnail Image (FULL VIBRANT COLOR, ZERO GRAYSCALE) -->
                            <Link :href="`/artikel/${post.slug}`" class="aspect-[16/10] overflow-hidden bg-zinc-100 relative block">
                                <img
                                    :src="post.thumbnail || fallbackArticleImg"
                                    :alt="post.title"
                                    class="w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-105"
                                />
                                <div class="absolute top-3 left-3 flex flex-wrap gap-2">
                                    <span class="px-2.5 py-1 text-[10px] font-mono font-bold rounded-md bg-orange-600 text-white shadow-sm uppercase">
                                        {{ post.category || 'REKAYASA SIPIL' }}
                                    </span>
                                </div>
                            </Link>

                            <!-- Content -->
                            <div class="p-6 flex-grow flex flex-col justify-between">
                                <div>
                                    <span class="text-xs font-mono text-zinc-400 block mb-2">
                                        {{ post.published_at || 'Terbaru' }}
                                    </span>
                                    <Link :href="`/artikel/${post.slug}`">
                                        <h2 class="text-xl font-display font-bold text-zinc-950 group-hover:text-orange-600 transition-colors leading-snug mb-3">
                                            {{ post.title }}
                                        </h2>
                                    </Link>
                                    <p class="text-xs sm:text-sm text-zinc-600 line-clamp-3 leading-relaxed mb-6">
                                        {{ post.excerpt }}
                                    </p>
                                </div>

                                <div class="pt-4 border-t border-zinc-100 flex items-center justify-between">
                                    <Link
                                        :href="`/artikel/${post.slug}`"
                                        class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-orange-600 hover:text-zinc-950 transition-colors"
                                    >
                                        <span>Baca Selengkapnya</span>
                                        <span class="transition-transform group-hover:translate-x-1">&rarr;</span>
                                    </Link>
                                </div>
                            </div>
                        </article>
                    </div>

                    <!-- Empty State -->
                    <div v-else class="text-center py-20 bg-white border border-zinc-200 rounded-xl p-8">
                        <svg class="w-16 h-16 mx-auto text-zinc-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                        </svg>
                        <h3 class="text-lg font-bold text-zinc-900 font-display">Tidak Ada Artikel</h3>
                        <p class="text-sm text-zinc-500 mt-1 max-w-sm mx-auto">
                            Belum ada publikasi yang cocok dengan kata kunci pencarian Anda.
                        </p>
                        <Link href="/artikel" class="inline-block mt-4 px-5 py-2.5 bg-zinc-950 text-white rounded text-xs font-bold uppercase tracking-wider hover:bg-orange-600 transition-colors">
                            Lihat Semua Artikel
                        </Link>
                    </div>

                    <!-- Pagination Links -->
                    <div v-if="posts.links && posts.links.length > 3" class="mt-12 flex justify-center gap-2">
                        <template v-for="(link, i) in posts.links" :key="i">
                            <Link
                                v-if="link.url"
                                :href="link.url"
                                class="px-4 py-2 text-xs font-bold rounded border transition-colors"
                                :class="link.active ? 'bg-orange-600 border-orange-600 text-white' : 'bg-white border-zinc-200 text-zinc-700 hover:bg-zinc-100'"
                                v-html="link.label"
                            />
                            <span
                                v-else
                                class="px-4 py-2 text-xs font-bold rounded border border-zinc-200 bg-zinc-50 text-zinc-400 opacity-60"
                                v-html="link.label"
                            />
                        </template>
                    </div>
                </div>
            </section>
        </main>

        <!-- Footer -->
        <footer class="bg-zinc-950 text-white py-12 border-t border-zinc-800">
            <div class="max-w-[1440px] mx-auto px-6 md:px-10 flex flex-col md:flex-row items-center justify-between gap-6 text-xs text-zinc-400">
                <p>© {{ new Date().getFullYear() }} {{ company_settings?.company_name ?? 'PT. Hariq Sakti Konstruksindo' }}. Hak Cipta Dilindungi Undang-Undang.</p>
                <div class="flex flex-wrap items-center gap-6 font-semibold uppercase tracking-wider text-zinc-300">
                    <Link class="hover:text-orange-400 transition-colors" href="/#beranda">Beranda</Link>
                    <Link class="hover:text-orange-400 transition-colors" href="/layanan">Layanan</Link>
                    <Link class="hover:text-orange-400 transition-colors" href="/proyek">Proyek</Link>
                    <Link class="text-orange-400 font-bold" href="/artikel">Artikel</Link>
                    <Link class="hover:text-orange-400 transition-colors" href="/#kontak">Kontak</Link>
                </div>
            </div>
        </footer>
    </div>
</template>
