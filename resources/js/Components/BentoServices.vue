<script setup lang="ts">
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

interface Service {
    id: number;
    title: string;
    slug?: string;
    description: string;
    icon?: string | null;
}

const props = defineProps<{ services: Service[] }>();

const emit = defineEmits<{
    (e: 'selectService', id: number): void;
}>();

// Fallback gambar konstruksi berkualitas jika belum ada foto terunggah
const fallbackServiceImage = 'https://lh3.googleusercontent.com/aida-public/AB6AXuAGmYhYPnJTdHfkC-nmTxBaPR-Yt-qKKuLc_O3BJYMUDN8-OAUFG8_bsFL2fNoMVZxrqCpuM4P_6vBtcQwFsBgEarNtp9roYuihqfniCgn3oVbiwkOG1l1bb_gsidvylHmx4m_ms1ZivT20AmMzPlpLkB8l0ZNpmJlh1wLJGnRK0k5Lj5GAw5Fuegu91V_SAqq9u4d5Invuptgq5n2dNtyP2aGgthACj4bKANr9AC7jEgLvJ331sPvw';

// Tampilkan maksimal 3 layanan utama di beranda agar rapi dan tidak terlalu panjang
const displayedServices = computed(() => {
    if (!props.services || props.services.length === 0) return [];
    return props.services.slice(0, 3);
});
</script>

<template>
    <section class="py-24 border-b border-zinc-200 bg-white" id="layanan">
        <div class="max-w-[1440px] mx-auto px-6 md:px-10">
            <!-- Section Header -->
            <div class="flex flex-col lg:flex-row lg:items-end justify-between mb-16 gap-8">
                <div>
                    <span class="text-xs uppercase tracking-widest font-bold text-orange-600 font-mono">KOMPETENSI TEKNIS</span>
                    <h2 class="text-4xl sm:text-5xl lg:text-6xl font-display font-extrabold text-zinc-950 mt-3 headline-tight">
                        LAYANAN <br>
                        YANG KAMI <br>
                        <span class="text-orange-600">KUASAI</span>
                    </h2>
                </div>
                <div class="max-w-md lg:pb-2">
                    <p class="text-zinc-600 text-sm sm:text-base leading-relaxed">
                        Pendekatan rekayasa terpadu yang mencakup perencanaan rancang bangun, eksekusi struktur sipil, manajemen proyek berpresisi tinggi, hingga pemeliharaan aset properti Anda.
                    </p>
                </div>
            </div>

            <!-- 3 Dynamic Featured Cards (Clean & 100% Data Dinamis Database) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <article
                    v-for="(service, idx) in displayedServices"
                    :key="service.id"
                    class="group bg-white border border-zinc-200 rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between hover:-translate-y-1.5 hover:border-orange-500/60"
                >
                    <!-- Card Top: Image & Index Badge -->
                    <div>
                        <div class="aspect-[16/10] overflow-hidden bg-zinc-100 relative">
                            <img
                                :src="service.icon || fallbackServiceImage"
                                :alt="service.title"
                                class="w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-105"
                            />
                            <!-- Nomor Indeks -->
                            <div class="absolute top-3 left-3">
                                <span class="px-2.5 py-1 text-[11px] font-mono font-bold rounded-md bg-zinc-950/85 text-white backdrop-blur-sm shadow-sm">
                                    0{{ idx + 1 }}
                                </span>
                            </div>
                        </div>

                        <!-- Card Content (Purely from Database) -->
                        <div class="p-6 sm:p-7">
                            <h3 class="text-xl sm:text-2xl font-display font-bold text-zinc-950 group-hover:text-orange-600 transition-colors leading-snug mb-3 capitalize">
                                {{ service.title }}
                            </h3>
                            <p class="text-xs sm:text-sm text-zinc-600 leading-relaxed line-clamp-4">
                                {{ service.description }}
                            </p>
                        </div>
                    </div>

                    <!-- Card Footer: Direct Consultation -->
                    <div class="p-6 sm:p-7 pt-0 mt-auto">
                        <div class="pt-4 border-t border-zinc-100 flex items-center justify-between">
                            <a
                                href="#kontak"
                                @click="emit('selectService', service.id)"
                                class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-orange-600 hover:text-zinc-950 transition-colors"
                            >
                                <span>Konsultasi Layanan Ini</span>
                                <span class="transition-transform group-hover:translate-x-1">→</span>
                            </a>
                        </div>
                    </div>
                </article>
            </div>

            <!-- CTA: Lihat Semua Layanan (Navigasi ke Halaman /layanan) -->
            <div class="mt-14 pt-8 border-t border-zinc-200 flex flex-col sm:flex-row items-center justify-between gap-6 bg-zinc-50 p-6 md:p-8 rounded-2xl border border-zinc-200/80 shadow-sm">
                <div>
                    <span class="text-[11px] font-mono font-bold uppercase tracking-wider text-orange-600">SELURUH BIDANG PEKERJAAN</span>
                    <h3 class="text-xl sm:text-2xl font-display font-bold text-zinc-950 mt-1">
                        Jelajahi Seluruh Ruang Lingkup Layanan Konstruksi
                    </h3>
                    <p class="text-zinc-600 text-sm mt-1 max-w-xl">
                        Kami melayani pekerjaan sipil terpadu, manajemen proyek, perencanaan struktur bangunan, hingga pemeliharaan berkala.
                    </p>
                </div>
                <Link
                    href="/layanan"
                    class="inline-flex items-center gap-3 px-7 py-4 bg-zinc-950 hover:bg-orange-600 text-white font-display font-bold text-xs uppercase tracking-wider rounded-xl transition-all duration-300 shadow-md hover:shadow-xl group flex-shrink-0"
                >
                    <span>LIHAT SEMUA LAYANAN</span>
                    <span class="text-base group-hover:translate-x-1 transition-transform">→</span>
                </Link>
            </div>
        </div>
    </section>
</template>
