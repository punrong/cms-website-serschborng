<template>
    <div
        class="min-h-screen flex flex-col sm:justify-center items-center pt-20 sm:pt-6 bg-gray-100"
    >
        <a class="inline-flex" href="\">
            <img class="object-contain h-32 w-96" src="../../../public/logo.png" />
        </a>

        <div
            class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg"
        >
            <slot />
        </div>
    </div>
</template>
