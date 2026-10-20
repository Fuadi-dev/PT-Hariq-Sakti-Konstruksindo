<script setup lang="ts">
import { computed, onBeforeUnmount, onMounted, ref } from 'vue';
import { usePage } from '@inertiajs/vue3';

const props = withDefaults(
    defineProps<{
        companySettings?: Record<string, any>;
        currentPage?: string; // 'beranda' | 'layanan' | 'proyek' | 'artikel' | 'tim' | 'kontak'
        isArticlePage?: boolean;
    }>(),
    {
        currentPage: '',
        isArticlePage: false,
    }
);

const page = usePage();

const isAtTop = ref(true);
const isScrolledPastHero = ref(false);
const activeSection = ref('beranda');
const mobileMenuOpen = ref(false);

const navLinks = [
    { name: 'BERANDA', id: 'beranda' },
    { name: 'LAYANAN', id: 'layanan' },
    { name: 'PROYEK', id: 'proyek' },
    { name: 'ARTIKEL', id: 'artikel' },
    { name: 'TIM', id: 'tim' },
    { name: 'KONTAK', id: 'kontak' },
];

const isSubPage = computed(() => {
    if (props.currentPage && props.currentPage !== 'beranda') return true;
    if (props.isArticlePage) return true;
    const url = page?.url ?? (typeof window !== 'undefined' ? window.location.pathname : '');
    return url.startsWith('/layanan') || url.startsWith('/proyek') || url.startsWith('/artikel');
});

const currentActiveSection = computed(() => {
    if (props.currentPage) return props.currentPage;
    const url = page?.url ?? (typeof window !== 'undefined' ? window.location.pathname : '');
    if (url.startsWith('/layanan')) return 'layanan';
    if (url.startsWith('/proyek')) return 'proyek';
    if (url.startsWith('/artikel')) return 'artikel';
    if (props.isArticlePage) return 'artikel';
    return activeSection.value;
});

const getHref = (id: string) => {
    const onSub = isSubPage.value;
    if (id === 'beranda') {
        return onSub ? '/' : '#beranda';
    }
    if (id === 'layanan') {
        return onSub ? '/layanan' : '#layanan';
    }
    if (id === 'proyek') {
        return onSub ? '/proyek' : '#proyek';
    }
    if (id === 'artikel') {
        return onSub ? '/artikel' : '#artikel';
    }
    return onSub ? `/#${id}` : `#${id}`;
};

const checkScrollState = () => {
    if (isSubPage.value) {
        isAtTop.value = false;
        isScrolledPastHero.value = true;
        return;
    }

    const scrollY = window.scrollY || document.documentElement.scrollTop;
    // Saat discroll mentok ke atas (scrollY <= 20)
    isAtTop.value = scrollY <= 20;

    const hero = document.getElementById('beranda');
    if (hero) {
        const rect = hero.getBoundingClientRect();
        // Berubah ke tema terang saat hero banner telah lewat navbar
        isScrolledPastHero.value = rect.bottom <= 80;
    } else {
        isScrolledPastHero.value = scrollY > 80;
    }

    // Deteksi section aktif
    const sections = ['kontak', 'tim', 'artikel', 'proyek', 'layanan', 'beranda'];
    for (const sec of sections) {
        const el = document.getElementById(sec);
        if (el) {
            const r = el.getBoundingClientRect();
            if (r.top <= 140 && r.bottom >= 140) {
                activeSection.value = sec;
                break;
            }
        }
    }
};

const handleLinkClick = () => {
    mobileMenuOpen.value = false;
};

onMounted(() => {
    checkScrollState();
    window.addEventListener('scroll', checkScrollState, { passive: true });
    window.addEventListener('resize', checkScrollState, { passive: true });
});

onBeforeUnmount(() => {
    window.removeEventListener('scroll', checkScrollState);
    window.removeEventListener('resize', checkScrollState);
});

// Format nomor WhatsApp untuk URL direct chat
const waUrl = computed(() => {
    const raw = props.companySettings?.whatsapp ?? '';
    const cleaned = raw.replace(/\D/g, '');
    return cleaned ? `https://wa.me/${cleaned}` : '#kontak';
});
</script>

<template>
    <!-- BEGIN: MainHeader -->
    <header
        class="fixed top-0 left-0 right-0 z-50 w-full transition-all duration-300 ease-in-out select-none"
        :class="[
            isAtTop
                ? 'bg-transparent border-b border-transparent shadow-none'
                : isScrolledPastHero
                    ? 'bg-white/95 backdrop-blur-md border-b border-zinc-200/90 shadow-sm'
                    : 'bg-zinc-950/85 backdrop-blur-md border-b border-white/10 shadow-lg'
        ]"
    >
        <div class="max-w-[1440px] mx-auto px-4 sm:px-6 md:px-10 h-20 flex items-center justify-between transition-all duration-300">
            <!-- Company Brand Identity / Logo (Sinkron tanpa kotak putih) -->
            <a
                :href="getHref('beranda')"
                aria-label="Beranda PT Hariq Sakti Konstruksindo"
                class="flex items-center gap-3 sm:gap-3.5 group transition-transform duration-300 hover:scale-[1.02] focus:outline-none"
            >
                <!-- Emblem HSK Transparan -->
                <img
                    :src="(!isAtTop && isScrolledPastHero) ? '/img/logo-emblem-light.png' : '/img/logo-emblem-dark.png'"
                    alt="Logo HSK"
                    class="h-9 sm:h-10 md:h-11 w-auto object-contain transition-all duration-300 drop-shadow-sm"
                />

                <!-- Tipografi Nama Perusahaan Rapi & Tajam -->
                <div class="flex flex-col text-left">
                    <span
                        class="font-display font-extrabold text-xs sm:text-sm md:text-[15px] tracking-tight leading-tight uppercase transition-colors duration-300 drop-shadow-sm"
                        :class="(!isAtTop && isScrolledPastHero) ? 'text-zinc-950' : 'text-white'"
                    >
                        PT. Hariq Sakti Konstruksindo
                    </span>
                    <span
                        class="font-mono text-[8px] sm:text-[9px] md:text-[10px] tracking-[0.16em] uppercase font-bold transition-colors duration-300"
                        :class="(!isAtTop && isScrolledPastHero) ? 'text-zinc-500' : 'text-zinc-300'"
                    >
                        General Contractor & MEP
                    </span>
                </div>
            </a>

            <!-- Primary Navigation Links (Desktop) -->
            <nav
                aria-label="Navigasi Utama"
                class="hidden md:flex items-center gap-6 lg:gap-8 xl:gap-10 text-xs font-bold tracking-wider uppercase transition-colors duration-300"
            >
                <a
                    v-for="link in navLinks"
                    :key="link.id"
                    :href="getHref(link.id)"
                    class="relative py-2 transition-all duration-200 group focus:outline-none drop-shadow-sm"
                    :class="[
                        (!isAtTop && isScrolledPastHero)
                            ? (currentActiveSection === link.id ? 'text-orange-600 font-extrabold' : 'text-zinc-700 hover:text-orange-600')
                            : (currentActiveSection === link.id ? 'text-orange-400 font-extrabold' : 'text-zinc-200 hover:text-orange-400')
                    ]"
                >
                    <span>{{ link.name }}</span>
                    <!-- Indikator garis bawah aktif/hover -->
                    <span
                        class="absolute bottom-0 left-0 h-0.5 rounded-full transition-all duration-300"
                        :class="[
                            (!isAtTop && isScrolledPastHero) ? 'bg-orange-600' : 'bg-orange-400',
                            currentActiveSection === link.id ? 'w-full' : 'w-0 group-hover:w-full'
                        ]"
                    ></span>
                </a>
            </nav>

            <!-- Action Consultation Button & Mobile Toggle -->
            <div class="flex items-center gap-3 sm:gap-4">
                <!-- CTA Button Desktop (Meniru gaya gambar kedua: outline di atas, solid saat scroll) -->
                <a
                    :href="getHref('kontak')"
                    class="hidden sm:inline-flex items-center justify-center gap-2 text-xs font-bold uppercase tracking-wider px-4 sm:px-5 py-2.5 sm:py-2.5 rounded transition-all duration-300 hover:scale-105 active:scale-95 focus:outline-none"
                    :class="[
                        (!isAtTop && isScrolledPastHero)
                            ? 'border border-zinc-900 bg-zinc-950 text-white hover:bg-orange-600 hover:border-orange-600 shadow-sm'
                            : isAtTop
                                ? 'border border-white/50 bg-white/10 backdrop-blur-xs text-white hover:bg-white hover:text-zinc-950 shadow-sm'
                                : 'border border-orange-500 bg-orange-600 text-white hover:bg-orange-500 shadow-[0_4px_16px_rgba(249,115,22,0.4)]'
                    ]"
                >
                    <span>Konsultasi Gratis</span>
                    <span class="text-sm transition-transform duration-200 group-hover:translate-x-0.5">&rarr;</span>
                </a>

                <!-- Mobile Hamburger Button -->
                <button
                    @click="mobileMenuOpen = !mobileMenuOpen"
                    :aria-expanded="mobileMenuOpen"
                    aria-label="Buka Menu Navigasi"
                    class="inline-flex md:hidden p-2.5 rounded-lg transition-all duration-300 focus:outline-none focus:ring-2"
                    :class="[
                        (!isAtTop && isScrolledPastHero)
                            ? 'text-zinc-900 bg-zinc-100 hover:bg-zinc-200 focus:ring-zinc-400'
                            : 'text-white bg-white/10 hover:bg-white/20 focus:ring-white/40'
                    ]"
                >
                    <!-- Animated hamburger icon -->
                    <svg class="w-6 h-6 transition-transform duration-300" :class="{ 'rotate-90': mobileMenuOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path
                            v-if="!mobileMenuOpen"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 6h16M4 12h16m-7 6h7"
                        />
                        <path
                            v-else
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"
                        />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Nav Dropdown / Drawer -->
        <transition
            enter-active-class="transition-all duration-300 ease-out"
            enter-from-class="opacity-0 -translate-y-4"
            enter-to-class="opacity-100 translate-y-0"
            leave-active-class="transition-all duration-200 ease-in"
            leave-from-class="opacity-100 translate-y-0"
            leave-to-class="opacity-0 -translate-y-4"
        >
            <div
                v-if="mobileMenuOpen"
                class="md:hidden border-b px-5 py-6 flex flex-col gap-3 shadow-2xl transition-all duration-300"
                :class="[
                    (!isAtTop && isScrolledPastHero)
                        ? 'bg-white/98 border-zinc-200 text-zinc-900'
                        : 'bg-zinc-950/98 border-white/10 text-white'
                ]"
            >
                <a
                    v-for="link in navLinks"
                    :key="link.id"
                    :href="getHref(link.id)"
                    @click="handleLinkClick"
                    class="flex items-center justify-between px-3 py-2.5 rounded-lg text-xs font-bold uppercase tracking-wider transition-colors duration-200"
                    :class="[
                        currentActiveSection === link.id
                            ? ((!isAtTop && isScrolledPastHero) ? 'bg-orange-50 text-orange-600' : 'bg-white/10 text-orange-400')
                            : ((!isAtTop && isScrolledPastHero) ? 'text-zinc-800 hover:bg-zinc-100 hover:text-orange-600' : 'text-zinc-200 hover:bg-white/10 hover:text-orange-400')
                    ]"
                >
                    <span>{{ link.name }}</span>
                    <span v-if="currentActiveSection === link.id" class="w-1.5 h-1.5 rounded-full bg-orange-500"></span>
                </a>

                <div class="pt-3 border-t flex flex-col gap-2.5" :class="(!isAtTop && isScrolledPastHero) ? 'border-zinc-200' : 'border-white/10'">
                    <!-- Quick WA Contact on Mobile -->
                    <a
                        v-if="companySettings?.whatsapp"
                        :href="waUrl"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="inline-flex items-center justify-center gap-2 text-xs font-bold uppercase tracking-wider px-4 py-3 rounded bg-emerald-600 hover:bg-emerald-500 text-white shadow-sm transition-colors"
                    >
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                            <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.771-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.312.045-.694.077-2.023-.473-1.615-.668-2.671-2.316-2.753-2.424-.082-.108-.66-88-.66-1.68 0-.8 4.417-1.196.565-1.348.148-.152.324-.19.432-.19.108 0 .216.002.311.007.1.006.234-.038.366.28.136.327.466 1.137.507 1.22.041.083.068.18.014.288-.054.108-.081.176-.162.271-.081.095-.171.213-.244.286-.081.082-.166.171-.071.334.095.163.421.696.904 1.126.622.553 1.146.724 1.309.805.163.081.258.068.354-.041.095-.109.406-.473.514-.635.108-.163.216-.136.365-.082.149.054.945.446 1.107.527.162.082.27.122.311.19.041.068.041.393-.103.798z"/>
                        </svg>
                        <span>WhatsApp: {{ companySettings.whatsapp }}</span>
                    </a>

                    <!-- CTA Button Mobile -->
                    <a
                        :href="getHref('kontak')"
                        @click="handleLinkClick"
                        class="inline-flex items-center justify-center text-xs font-bold uppercase tracking-wider px-4 py-3 rounded transition-colors text-center"
                        :class="[
                            (!isAtTop && isScrolledPastHero)
                                ? 'bg-zinc-950 text-white hover:bg-orange-600'
                                : 'bg-orange-600 text-white hover:bg-orange-500'
                        ]"
                    >
                        Konsultasi Gratis &rarr;
                    </a>
                </div>
            </div>
        </transition>
    </header>
    <!-- END: MainHeader -->
</template>
