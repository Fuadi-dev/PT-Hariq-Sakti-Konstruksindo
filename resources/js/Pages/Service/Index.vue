<script setup lang="ts">
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import Navbar from '@/Components/Navbar.vue';

interface ServiceItem {
    id: number;
    title: string;
    slug?: string;
    description: string;
    image?: string | null;
}

interface PaginationLink {
    url: string | null;
    label: string;
    active: boolean;
}

interface PaginatedServices {
    data: ServiceItem[];
    links: PaginationLink[];
    current_page: number;
    last_page: number;
    total: number;
}

const props = defineProps<{
    company_settings: Record<string, any>;
    services: PaginatedServices;
    filters: {
        q?: string;
    };
}>();

const searchQuery = ref(props.filters.q ?? '');

const handleSearch = () => {
    router.get(
        '/layanan',
        { q: searchQuery.value },
        {
            preserveState: true,
            replace: true,
        }
    );
};

const fallbackServiceImage =
    'https://lh3.googleusercontent.com/aida-public/AB6AXuAGmYhYPnJTdHfkC-nmTxBaPR-Yt-qKKuLc_O3BJYMUDN8-OAUFG8_bsFL2fNoMVZxrqCpuM4P_6vBtcQwFsBgEarNtp9roYuihqfniCgn3oVbiwkOG1l1bb_gsidvylHmx4m_ms1ZivT20AmMzPlpLkB8l0ZNpmJlh1wLJGnRK0k5Lj5GAw5Fuegu91V_SAqq9u4d5Invuptgq5n2dNtyP2aGgthACj4bKANr9AC7jEgLvJ331sPvw';
</script>

<template>
    <Head :title="`Layanan Konstruksi & Engineering — ${company_settings?.company_name ?? 'PT. Hariq Sakti Konstruksindo'}`">
        <meta
            name="description"
            content="Solusi menyeluruh layanan konstruksi sipil, arsitektural, manajemen proyek, MEP, dan pemeliharaan struktur dari PT. Hariq Sakti Konstruksindo."
        />
    </Head>

    <div class="bg-white text-zinc-900 selection:bg-orange-500 selection:text-white min-h-screen flex flex-col justify-between">
        <!-- MainHeader with current-page="layanan" -->
        <Navbar :company-settings="company_settings" current-page="layanan" />

        <main class="flex-grow pt-20">
            <!-- Header Banner Section -->
            <section class="border-b border-zinc-200 bg-zinc-950 text-white py-14 sm:py-20 relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-r from-orange-950/40 via-transparent to-zinc-950 pointer-events-none"></div>
                <div class="max-w-[1440px] mx-auto px-6 md:px-10 relative z-10">
                    <!-- Breadcrumbs -->
                    <nav class="flex items-center gap-2 text-xs font-mono text-zinc-400 uppercase tracking-wider mb-6">
                        <Link href="/" class="hover:text-orange-400 transition-colors">Beranda</Link>
                        <span>/</span>
                        <span class="text-orange-400 font-bold">Layanan Kami</span>
                    </nav>

                    <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-8">
                        <div>
                            <span class="text-xs uppercase tracking-widest font-mono text-orange-400 font-bold">KOMPETENSI TEKNIS LENGKAP</span>
                            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-display font-extrabold text-white mt-3 headline-tight">
                                Layanan <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-400 via-orange-500 to-amber-400">Konstruksi Kami</span>
                            </h1>
                            <p class="text-zinc-300 text-sm sm:text-base max-w-2xl mt-4 leading-relaxed">
                                Pendekatan rekayasa terintegrasi yang mencakup perencanaan rancang bangun, eksekusi struktur sipil berpresisi tinggi, mekanikal-elektrikal, hingga pemeliharaan aset properti Anda.
                            </p>
                        </div>

                        <!-- Search Bar -->
                        <div class="w-full lg:w-96">
                            <form @submit.prevent="handleSearch" class="relative">
                                <input
                                    v-model="searchQuery"
                                    type="text"
                                    placeholder="Cari jenis layanan, MEP, sipil..."
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

            <!-- Services Grid Section -->
            <section class="py-16 sm:py-20 bg-zinc-50/60">
                <div class="max-w-[1440px] mx-auto px-6 md:px-10">
                    <div v-if="services.data.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        <article
                            v-for="(s, idx) in services.data"
                            :key="s.id"
                            class="group bg-white border border-zinc-200 rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between hover:-translate-y-1.5 hover:border-orange-500/60"
                        >
                            <div>
                                <!-- Image (FULL COLOR, ZERO GRAYSCALE) -->
                                <div class="aspect-[16/10] overflow-hidden bg-zinc-100 relative">
                                    <img
                                        :src="s.image || fallbackServiceImage"
                                        :alt="s.title"
                                        class="w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-105"
                                    />
                                    <div class="absolute top-3 left-3">
                                        <span class="px-2.5 py-1 text-[11px] font-mono font-bold rounded-md bg-zinc-950/85 text-white backdrop-blur-sm shadow-sm">
                                            0{{ idx + 1 }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Content -->
                                <div class="p-6 sm:p-7">
                                    <h2 class="text-xl sm:text-2xl font-display font-bold text-zinc-950 group-hover:text-orange-600 transition-colors leading-snug mb-3 capitalize">
                                        {{ s.title }}
                                    </h2>
                                    <p class="text-xs sm:text-sm text-zinc-600 leading-relaxed">
                                        {{ s.description }}
                                    </p>
                                </div>
                            </div>

                            <!-- Card Footer: Consultation CTA -->
                            <div class="p-6 sm:p-7 pt-0 mt-auto">
                                <div class="pt-4 border-t border-zinc-100 flex items-center justify-between">
                                    <a
                                        href="/#kontak"
                                        class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-orange-600 hover:text-zinc-950 transition-colors"
                                    >
                                        <span>Konsultasikan Layanan</span>
                                        <span class="transition-transform group-hover:translate-x-1">&rarr;</span>
                                    </a>
                                </div>
                            </div>
                        </article>
                    </div>

                    <!-- Empty State -->
                    <div v-else class="text-center py-20 bg-white border border-zinc-200 rounded-xl p-8">
                        <svg class="w-16 h-16 mx-auto text-zinc-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        <h3 class="text-lg font-bold text-zinc-900 font-display">Layanan Tidak Ditemukan</h3>
                        <p class="text-sm text-zinc-500 mt-1 max-w-sm mx-auto">
                            Tidak ada jenis layanan yang sesuai dengan kata kunci pencarian Anda.
                        </p>
                        <Link href="/layanan" class="inline-block mt-4 px-5 py-2.5 bg-zinc-950 text-white rounded text-xs font-bold uppercase tracking-wider hover:bg-orange-600 transition-colors">
                            Lihat Semua Layanan
                        </Link>
                    </div>

                    <!-- Pagination Links -->
                    <div v-if="services.links && services.links.length > 3" class="mt-12 flex justify-center gap-2">
                        <template v-for="(link, i) in services.links" :key="i">
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
                    <Link class="text-orange-400 font-bold" href="/layanan">Layanan</Link>
                    <Link class="hover:text-orange-400 transition-colors" href="/proyek">Proyek</Link>
                    <Link class="hover:text-orange-400 transition-colors" href="/artikel">Artikel</Link>
                    <Link class="hover:text-orange-400 transition-colors" href="/#kontak">Kontak</Link>
                </div>
            </div>
        </footer>
    </div>
</template>
