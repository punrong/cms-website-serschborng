<template>
    <div
        class="relative pt-16 pb-32 flex w-full content-center items-center justify-center"
        style="min-height: 75vh"
    >
        <div
            class="absolute top-0 w-full h-full bg-center bg-cover"
            :style="`background-image: url('${mentor.image}')`"
        >
            <span id="blackOverlay" class="w-full h-full absolute"></span>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        mentor: {
            type: Object,
            default: () => ({}),
        },
    },
};
</script>
