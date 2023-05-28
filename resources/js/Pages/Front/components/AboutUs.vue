<template>
    <div class="container mx-auto py-8">
        <div class="text-center">
            <h5 class="text-3xl font-bold mt-5">About Us</h5>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 m-5">
            <div class="flex justify-end">
                <img
                    class="rounded-lg w-full sm:max-w-sm md:max-w-md lg:max-w-lg "
                    src="https://tecdn.b-cdn.net/img/new/standard/nature/184.jpg"
                    alt=""
                />
            </div>
            <div>
                <div>
                    <h3 class="text-xl font-bold mb-2">Mission</h3>
                    <p class="text-gray-700">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                        Nullam auctor rutrum ante a semper.
                    </p>
                </div>
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
