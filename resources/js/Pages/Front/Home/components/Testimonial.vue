<template>
    <section class="bg-gray-200 mt-20">
        <div
            class="mx-auto px-4 py-16 sm:px-6 sm:py-24 lg:me-0 lg:pe-0 lg:ps-8"
        >
            <div
                class="grid grid-cols-1 gap-y-8 lg:grid-cols-3 lg:items-center lg:gap-x-16"
            >
                <div
                    class="max-w-max text-center ltr:sm:text-left rtl:sm:text-right"
                >
                    <h2 class="text-3xl font-bold tracking-tight sm:text-4xl">
                        {{ testimonialTitle.title }}
                    </h2>

                    <p
                        class="mt-4 text-gray-500"
                        v-html="testimonialTitle.description"
                    ></p>

                    <div class="hidden justify-center lg:mt-8 lg:flex lg:gap-4">
                        <button
                            class="prev-button-testimonial rounded-full border border-blue-600 p-3 text-blue-600 hover:bg-blue-600 hover:text-white"
                        >
                            <span class="sr-only">Previous Slide</span>
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="h-5 w-5 rtl:rotate-180"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M15.75 19.5L8.25 12l7.5-7.5"
                                />
                            </svg>
                        </button>

                        <button
                            class="next-button-testimonial rounded-full border border-blue-600 p-3 text-blue-600 hover:bg-blue-600 hover:text-white"
                        >
                            <span class="sr-only">Next Slide</span>
                            <svg
                                class="h-5 w-5 rtl:rotate-180"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    d="M9 5l7 7-7 7"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="-mx-6 lg:col-span-2 lg:mx-0">
                    <div class="swiper-container-testimonial !overflow-hidden">
                        <div class="swiper-wrapper">
                            <div
                                v-for="(
                                    testimonial, index
                                ) in testimonialItem"
                                :key="index"
                                class="swiper-slide"
                            >
                                <blockquote
                                    class="flex h-full flex-col justify-center items-center bg-white p-12"
                                >
                                    <div
                                        class="w-9/12 sm:w-7/12 md:w-6/12 lg:w-6/12"
                                    >
                                        <img
                                            :src="testimonial.image"
                                            class="shadow-lg rounded-full"
                                        />
                                    </div>
                                    <div>
                                        <div class="mt-4">
                                            <p
                                                class="text-2xl font-bold text-blue-600 sm:text-3xl"
                                            >
                                                {{ testimonial.title }}
                                            </p>

                                            <p
                                                class="mt-4 leading-relaxed text-gray-500"
                                                v-html="
                                                    testimonial.description
                                                "
                                            ></p>
                                        </div>
                                    </div>
                                </blockquote>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8 flex justify-center gap-4 lg:hidden">
                <button
                    aria-label="Previous slide"
                    class="prev-button-testimonial rounded-full border border-blue-600 p-4 text-blue-600 hover:bg-blue-600 hover:text-white"
                >
                    <svg
                        class="h-5 w-5 -rotate-180 transform"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            d="M9 5l7 7-7 7"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                        />
                    </svg>
                </button>

                <button
                    aria-label="Next slide"
                    class="next-button-testimonial rounded-full border border-blue-600 p-4 text-blue-600 hover:bg-blue-600 hover:text-white"
                >
                    <svg
                        class="h-5 w-5"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            d="M9 5l7 7-7 7"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                        />
                    </svg>
                </button>
            </div>
        </div>
    </section>
</template>

<script>
import { Ripple, initTE } from "tw-elements";
import Swiper from "swiper";
import "swiper/swiper-bundle.min.css";
export default {
    props: {
        testimonialTitle: {
            type: Object,
            default: () => ({}),
        },
        testimonialItem: {
            type: Object,
            default: () => ({}),
        },
    },
    mounted() {
        // Call the initTE function to initialize the "tw-elements" library
        initTE({ Ripple });

        new Swiper(".swiper-container-testimonial", {
            loop: false,
            slidesPerView: 1,
            spaceBetween: 32,
            autoplay: {
                delay: 8000,
            },
            breakpoints: {
                640: {
                    centeredSlides: true,
                    slidesPerView: 1.25,
                },
                1024: {
                    centeredSlides: false,
                    slidesPerView: 1.5,
                },
            },
            navigation: {
                nextEl: ".next-button-testimonial",
                prevEl: ".prev-button-testimonial",
            },
        });
    },
};
</script>
