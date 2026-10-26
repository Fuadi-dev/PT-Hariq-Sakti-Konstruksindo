<script setup lang="ts">
import { onMounted, ref, watch } from 'vue';

/**
 * Logo dengan auto-zoom: area kosong (transparan / putih polos) di sekeliling logo
 * dipangkas otomatis sehingga logo yang framenya kecil tetap terlihat proporsional.
 * Jika gambar tidak bisa dibaca (mis. CORS) maka gambar asli ditampilkan apa adanya.
 */
const props = defineProps<{
    src: string;
    alt: string;
}>();

const displaySrc = ref(props.src);

const PADDING = 0.06; // ruang napas 6% di sekeliling logo setelah dipangkas
const MAX_SAMPLE = 400; // batas ukuran sampling agar ringan
const MIN_CROP_RATIO = 0.97; // jika hasil pangkas hampir sama dengan aslinya, tidak perlu diproses

const isBackground = (r: number, g: number, b: number, a: number) =>
    a < 24 || (r > 244 && g > 244 && b > 244);

const autoZoom = (url: string) => {
    const img = new Image();
    img.crossOrigin = 'anonymous';

    img.onload = () => {
        try {
            const scale = Math.min(1, MAX_SAMPLE / Math.max(img.naturalWidth, img.naturalHeight));
            const w = Math.max(1, Math.round(img.naturalWidth * scale));
            const h = Math.max(1, Math.round(img.naturalHeight * scale));

            const probe = document.createElement('canvas');
            probe.width = w;
            probe.height = h;
            const pctx = probe.getContext('2d', { willReadFrequently: true });
            if (!pctx) return;
            pctx.drawImage(img, 0, 0, w, h);
            const { data } = pctx.getImageData(0, 0, w, h);

            let minX = w, minY = h, maxX = -1, maxY = -1;
            for (let y = 0; y < h; y++) {
                for (let x = 0; x < w; x++) {
                    const i = (y * w + x) * 4;
                    if (!isBackground(data[i], data[i + 1], data[i + 2], data[i + 3])) {
                        if (x < minX) minX = x;
                        if (x > maxX) maxX = x;
                        if (y < minY) minY = y;
                        if (y > maxY) maxY = y;
                    }
                }
            }

            if (maxX < 0) return; // gambar kosong / seluruhnya putih

            const cw = maxX - minX + 1;
            const ch = maxY - minY + 1;
            if (cw / w > MIN_CROP_RATIO && ch / h > MIN_CROP_RATIO) return; // sudah penuh

            // Tambahkan padding lalu konversi ke koordinat gambar asli (resolusi penuh)
            const padX = Math.round(cw * PADDING);
            const padY = Math.round(ch * PADDING);
            const sx = Math.max(0, minX - padX) / scale;
            const sy = Math.max(0, minY - padY) / scale;
            const sw = Math.min(w, maxX + padX + 1) / scale - sx;
            const sh = Math.min(h, maxY + padY + 1) / scale - sy;

            const out = document.createElement('canvas');
            out.width = Math.round(sw);
            out.height = Math.round(sh);
            const octx = out.getContext('2d');
            if (!octx) return;
            octx.drawImage(img, sx, sy, sw, sh, 0, 0, out.width, out.height);

            displaySrc.value = out.toDataURL('image/png');
        } catch {
            // Canvas tainted / gagal dibaca -> pakai gambar asli
            displaySrc.value = url;
        }
    };

    img.src = url;
};

onMounted(() => autoZoom(props.src));
watch(() => props.src, (url) => {
    displaySrc.value = url;
    autoZoom(url);
});
</script>

<template>
    <img :src="displaySrc" :alt="alt" :title="alt" loading="lazy" />
</template>
