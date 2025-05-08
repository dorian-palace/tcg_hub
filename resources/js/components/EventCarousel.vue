<template>
    <div class="event-carousel">
        <swiper
            :modules="[Autoplay, Pagination, Navigation]"
            :slides-per-view="1"
            :space-between="30"
            :loop="true"
            :autoplay="{
                delay: 3000,
                disableOnInteraction: false,
            }"
            :pagination="{
                clickable: true,
            }"
            :navigation="true"
            class="mySwiper"
        >
            <swiper-slide v-for="event in events" :key="event.id">
                <div class="event-card">
                    <img :src="event.image" :alt="event.title" class="event-image">
                    <div class="event-content">
                        <h3 class="event-title">{{ event.title }}</h3>
                        <p class="event-date">{{ event.date }}</p>
                        <p class="event-location">{{ event.location }}</p>
                        <p class="event-description">{{ event.description }}</p>
                    </div>
                </div>
            </swiper-slide>
        </swiper>
    </div>
</template>

<script setup>
import { Swiper, SwiperSlide } from 'swiper/vue';
import { Autoplay, Pagination, Navigation } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/pagination';
import 'swiper/css/navigation';

const events = [
    {
        id: 1,
        title: "Championnat de France Pokémon TCG",
        date: "15-16 Juin 2024",
        location: "Paris",
        description: "Le plus grand tournoi Pokémon TCG de France",
        image: "https://placehold.co/800x400/2563eb/ffffff?text=Pokemon+Championship"
    },
    {
        id: 2,
        title: "Grand Prix Magic: The Gathering",
        date: "20-21 Juillet 2024",
        location: "Lyon",
        description: "Tournoi majeur de Magic: The Gathering",
        image: "https://placehold.co/800x400/2563eb/ffffff?text=Magic+GP"
    },
    {
        id: 3,
        title: "Yu-Gi-Oh! Championship Series",
        date: "10-11 Août 2024",
        location: "Marseille",
        description: "Compétition nationale Yu-Gi-Oh!",
        image: "https://placehold.co/800x400/2563eb/ffffff?text=Yu-Gi-Oh+Championship"
    }
];
</script>

<style scoped>
.event-carousel {
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem 0;
}

.event-card {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    height: 400px;
}

.event-image {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

.event-content {
    padding: 1.5rem;
}

.event-title {
    font-size: 1.5rem;
    font-weight: bold;
    margin-bottom: 0.5rem;
    color: #333;
}

.event-date, .event-location {
    color: #666;
    margin-bottom: 0.5rem;
}

.event-description {
    color: #444;
    font-size: 0.9rem;
    line-height: 1.4;
}

:deep(.swiper-button-next),
:deep(.swiper-button-prev) {
    color: #333;
}

:deep(.swiper-pagination-bullet-active) {
    background: #333;
}

/* Styles supplémentaires pour Swiper */
:deep(.swiper) {
    width: 100%;
    height: 100%;
}

:deep(.swiper-slide) {
    text-align: center;
    background: #fff;
    display: flex;
    justify-content: center;
    align-items: center;
}

:deep(.swiper-button-next:after),
:deep(.swiper-button-prev:after) {
    font-size: 24px;
}
</style> 