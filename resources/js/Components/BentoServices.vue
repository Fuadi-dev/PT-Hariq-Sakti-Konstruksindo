<script setup lang="ts">
// PROPS DARI LARAVEL: services (tabel services)
interface Service { id: number; title: string; description: string; icon?: string }
defineProps<{ services: Service[] }>();

// Pola bento asimetris: kelas span per indeks (berulang tiap 6 item)
const pattern = [
    'md:col-span-4 md:row-span-2 bg-zinc-900 text-zinc-50',
    'md:col-span-2 bg-orange-600 text-zinc-50',
    'md:col-span-2 bg-zinc-50',
    'md:col-span-3 bg-zinc-50',
    'md:col-span-3 bg-zinc-200',
    'md:col-span-6 bg-zinc-50',
];
</script>

<template>
    <section id="layanan" class="border-b-2 border-zinc-900">
        <div class="mx-auto max-w-[1440px] px-5 py-20 sm:px-10 lg:py-28">
            <div class="mb-14 grid gap-6 lg:grid-cols-12">
                <h2 class="text-5xl font-black uppercase leading-[0.9] tracking-tighter sm:text-7xl lg:col-span-7">
                    Layanan<br />yang kami<br /><span class="text-orange-600">kuasai</span>
                </h2>
                <p class="self-end text-zinc-600 lg:col-span-4 lg:col-start-9">
                    Satu tim, satu standar mutu. Setiap layanan ditangani insinyur berpengalaman dengan pelaporan progres yang transparan.
                </p>
            </div>

            <div class="grid auto-rows-[minmax(220px,auto)] grid-cols-1 gap-0 border-2 border-zinc-900 md:grid-cols-6">
                <!-- PROPS: render setiap item services -->
                <article v-for="(s, i) in services" :key="s.id"
                    class="group relative flex flex-col justify-between border-zinc-900 p-7 transition-colors duration-300 hover:bg-zinc-800 hover:text-zinc-50 max-md:border-b-2 md:border-b-2 md:border-r-2"
                    :class="pattern[i % pattern.length]">
                    <span class="font-mono text-xs opacity-60">{{ String(i + 1).padStart(2, '0') }}</span>
                    <div>
                        <h3 class="mb-3 text-2xl font-bold leading-tight tracking-tight" :class="i % 6 === 0 ? 'sm:text-4xl' : ''">
                            {{ s.title }}
                        </h3>
                        <p class="max-w-md text-sm leading-relaxed opacity-75">{{ s.description }}</p>
                    </div>
                    <span class="absolute right-6 top-6 text-xl opacity-0 transition-all group-hover:translate-x-1 group-hover:opacity-100">↗</span>
                </article>
            </div>
        </div>
    </section>
</template>
