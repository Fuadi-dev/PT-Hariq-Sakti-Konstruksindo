<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import HeroSection from '@/Components/HeroSection.vue';
import BentoServices from '@/Components/BentoServices.vue';

// PROPS DARI LARAVEL (dikirim via Inertia::render('Home/Index', [...]))
const props = defineProps<{
    company_settings: Record<string, any>;
    sliders: Array<{ id: number; title: string; subtitle?: string | null; image: string; button_text?: string | null; button_url?: string | null }>;
    services: Array<{ id: number; title: string; description: string }>;
    clients: Array<{ id: number; name: string; logo: string }>;
    projects: Array<{ id: number; title: string; image: string; category?: string; year?: string | number }>;
    posts: Array<{ id: number; title: string; slug: string; excerpt?: string; thumbnail?: string; published_at?: string }>;
    testimonials: Array<{ id: number; name: string; company?: string; content: string }>;
}>();

// Form kontak: POST ke Laravel, lalu controller redirect ke WhatsApp
const form = useForm({ name: '', company: '', message: '' });
const submit = () => form.post('/contact', { preserveScroll: true, onSuccess: () => form.reset() });

const underline =
    'w-full border-0 border-b-2 border-zinc-300 bg-transparent px-0 py-3 text-lg placeholder:text-zinc-400 focus:border-orange-600 focus:outline-none focus:ring-0 transition-colors';
</script>

<template>
    <Head :title="company_settings?.company_name ?? 'Beranda'">
        <meta name="description" :content="company_settings?.tagline ?? 'Kontraktor sipil dan struktur terpercaya.'" />
    </Head>

    <div class="bg-zinc-50 text-zinc-900 antialiased">
        <!-- Navbar -->
        <header class="sticky top-0 z-40 border-b-2 border-zinc-900 bg-zinc-50/95 backdrop-blur">
            <nav class="mx-auto flex max-w-[1440px] items-center justify-between px-5 py-4 sm:px-10">
                <a href="/" class="text-sm font-black uppercase tracking-tight">{{ company_settings?.company_name ?? 'HSK' }}</a>
                <div class="hidden gap-8 text-xs font-semibold uppercase tracking-widest md:flex">
                    <a href="#layanan" class="hover:text-orange-600">Layanan</a>
                    <a href="#proyek" class="hover:text-orange-600">Proyek</a>
                    <a href="#artikel" class="hover:text-orange-600">Artikel</a>
                    <a href="#kontak" class="hover:text-orange-600">Kontak</a>
                </div>
            </nav>
        </header>

        <HeroSection :settings="company_settings" :projects="projects" :sliders="sliders" />

        <!-- Marquee klien (PROPS: clients[].logo) -->
        <section class="overflow-hidden border-b-2 border-zinc-900 py-8">
            <div class="marquee flex w-max items-center gap-16 px-8">
                <img v-for="(c, i) in [...clients, ...clients]" :key="i" :src="c.logo" :alt="c.name"
                    class="h-10 w-auto opacity-50 grayscale transition hover:opacity-100 hover:grayscale-0" />
            </div>
        </section>

        <BentoServices :services="services" />

        <!-- Galeri proyek (PROPS: projects) -->
        <section id="proyek" class="border-b-2 border-zinc-900">
            <div class="mx-auto max-w-[1440px] px-5 py-20 sm:px-10 lg:py-28">
                <h2 class="mb-14 text-5xl font-black uppercase leading-[0.9] tracking-tighter sm:text-7xl">Karya<br />terpilih</h2>
                <div class="grid grid-cols-1 gap-6 md:grid-cols-12">
                    <a v-for="(p, i) in projects" :key="p.id" href="#"
                        class="group block"
                        :class="i % 3 === 0 ? 'md:col-span-7' : i % 3 === 1 ? 'md:col-span-5 md:mt-24' : 'md:col-span-12'">
                        <div class="overflow-hidden border-2 border-zinc-900 bg-zinc-200">
                            <img :src="p.image" :alt="p.title"
                                class="aspect-[4/3] w-full object-cover transition duration-700 group-hover:scale-[1.03]"
                                :class="i % 3 === 2 ? 'md:aspect-[21/9]' : ''" />
                        </div>
                        <div class="mt-3 flex items-baseline justify-between">
                            <h3 class="text-xl font-bold group-hover:text-orange-600">{{ p.title }}</h3>
                            <span class="font-mono text-xs uppercase text-zinc-500">{{ p.category }} {{ p.year }}</span>
                        </div>
                    </a>
                </div>
            </div>
        </section>

        <!-- Testimoni (PROPS: testimonials) -->
        <section class="border-b-2 border-zinc-900 bg-zinc-900 text-zinc-50">
            <div class="mx-auto grid max-w-[1440px] divide-zinc-700 md:grid-cols-3 md:divide-x">
                <figure v-for="t in testimonials.slice(0, 3)" :key="t.id" class="flex flex-col justify-between p-8 sm:p-10">
                    <blockquote class="mb-10 text-xl leading-snug">“{{ t.content }}”</blockquote>
                    <figcaption class="font-mono text-xs uppercase tracking-wider text-zinc-400">
                        {{ t.name }}<span v-if="t.company"> — {{ t.company }}</span>
                    </figcaption>
                </figure>
            </div>
        </section>

        <!-- Artikel (PROPS: posts) -->
        <section id="artikel" class="border-b-2 border-zinc-900">
            <div class="mx-auto max-w-[1440px] px-5 py-20 sm:px-10">
                <h2 class="mb-10 text-4xl font-black uppercase tracking-tighter sm:text-6xl">Catatan lapangan</h2>
                <ul class="divide-y-2 divide-zinc-900 border-y-2 border-zinc-900">
                    <li v-for="post in posts" :key="post.id">
                        <a :href="`/artikel/${post.slug}`" class="group grid items-center gap-2 py-6 transition-colors hover:bg-zinc-100 md:grid-cols-12 md:px-3">
                            <span class="font-mono text-xs uppercase text-zinc-500 md:col-span-2">{{ post.published_at }}</span>
                            <h3 class="text-xl font-bold group-hover:text-orange-600 md:col-span-6">{{ post.title }}</h3>
                            <p class="line-clamp-2 text-sm text-zinc-600 md:col-span-4">{{ post.excerpt }}</p>
                        </a>
                    </li>
                </ul>
            </div>
        </section>

        <!-- Kontak -->
        <section id="kontak" class="mx-auto grid max-w-[1440px] gap-12 px-5 py-20 sm:px-10 lg:grid-cols-12 lg:py-28">
            <div class="lg:col-span-5">
                <h2 class="text-5xl font-black uppercase leading-[0.9] tracking-tighter sm:text-7xl">
                    Punya<br />proyek?<br /><span class="text-orange-600">Mari bicara.</span>
                </h2>
                <p class="mt-6 max-w-sm text-zinc-600">Ceritakan kebutuhan Anda. Tim kami membalas melalui WhatsApp dalam satu hari kerja.</p>
            </div>

            <form class="space-y-8 lg:col-span-6 lg:col-start-7" @submit.prevent="submit">
                <div>
                    <input v-model="form.name" type="text" placeholder="Nama Anda" :class="underline" />
                    <p v-if="form.errors.name" class="mt-1 text-sm text-red-600">{{ form.errors.name }}</p>
                </div>
                <div>
                    <input v-model="form.company" type="text" placeholder="Perusahaan" :class="underline" />
                    <p v-if="form.errors.company" class="mt-1 text-sm text-red-600">{{ form.errors.company }}</p>
                </div>
                <div>
                    <textarea v-model="form.message" rows="4" placeholder="Ceritakan proyek Anda" :class="underline" />
                    <p v-if="form.errors.message" class="mt-1 text-sm text-red-600">{{ form.errors.message }}</p>
                </div>
                <button type="submit" :disabled="form.processing"
                    class="bg-zinc-900 px-8 py-4 text-sm font-semibold uppercase tracking-wider text-zinc-50 transition-colors hover:bg-orange-600 disabled:opacity-50">
                    {{ form.processing ? 'Mengirim…' : 'Kirim via WhatsApp →' }}
                </button>
            </form>
        </section>

        <!-- Footer (PROPS: company_settings) -->
        <footer class="border-t-2 border-zinc-900 px-5 py-10 sm:px-10">
            <div class="mx-auto flex max-w-[1440px] flex-col justify-between gap-4 font-mono text-xs uppercase text-zinc-500 md:flex-row">
                <span>© {{ new Date().getFullYear() }} {{ company_settings?.company_name }}</span>
                <span>{{ company_settings?.address }}</span>
                <span>{{ company_settings?.email }}</span>
            </div>
        </footer>
    </div>
</template>

<style scoped>
.marquee { animation: marquee 35s linear infinite; }
.marquee:hover { animation-play-state: paused; }
@keyframes marquee { to { transform: translateX(-50%); } }
</style>
