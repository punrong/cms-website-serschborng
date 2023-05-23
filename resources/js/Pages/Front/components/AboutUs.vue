<template>
    <div>
        <div class="text-center">
            <h5 class="text-3xl font-bold mt-5">About Us</h5>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-12 gap-4 mt-5">
            <div
                class="sm:col-span-4 bg-gray-200 flex justify-center items-center"
            >
                First item
            </div>
            <div
                class="sm:col-span-8 bg-gray-300 flex justify-center items-center"
            >
                Second item
            </div>
        </div>
    </div>
</template>

<script>
import { Ripple, initTE } from "tw-elements";
export default {
    mounted() {
        // Call the initTE function to initialize the "tw-elements" library
        initTE({ Ripple });
    },
};
</script>
