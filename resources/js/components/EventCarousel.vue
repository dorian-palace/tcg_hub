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
                    <img 
                        :src="event.image" 
                        :alt="event.title" 
                        class="event-image"
                        loading="lazy"
                        @error="event.image = '/images/placeholder.jpg'"
                    >
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
        title: "Japan Expo Paris 2025",
        date: "Juillet 2025 (Dates à confirmer)",
        location: "Paris Nord Villepinte",
        description: "Le plus grand événement de la culture japonaise en Europe avec des tournois Pokémon TCG, Yu-Gi-Oh! et Magic: The Gathering.",
        image: "/images/events/paris-logo.png"
    },
    // {
    //     id: 3,
    //     title: "Magic: The Gathering Pro Tour France 2025",
    //     date: "Juillet 2025 (Dates et lieu à confirmer)",
    //     location: "À déterminer (probablement Lyon ou une autre grande ville)",
    //     description: "Tournoi majeur de Magic: The Gathering avec des récompenses importantes et des joueurs professionnels du monde entier.",
    // },
    // {
    //     id: 4,
    //     title: "Yu-Gi-Oh! Championship Series France 2025",
    //     date: "Août 2025 (Dates et lieu à confirmer)",
    //     location: "À déterminer (pourrait revenir à Marseille ou une autre ville)",
    //     description: "Compétition nationale Yu-Gi-Oh! de grande envergure avec des prix exclusifs et des opportunités de se qualifier pour les Championnats du Monde.",
    // },
    // {
    //     id: 5,
    //     title: "Foire du Jeu de Paris 2025",
    //     date: "Juin 2025 (Dates à confirmer)",
    //     location: "Paris",
    //     description: "Grand événement dédié aux jeux sous toutes leurs formes, incluant des tournois de TCG, des démonstrations et des rencontres avec des acteurs de l'industrie.",
    // },
    {
        id: 6,
        title: "Pocardheim 2025",
        date: "5-6 Juillet 2025",
        location: "Heimsbrunn (Alsace)",
        description: "Festival dédié aux TCG avec un focus sur la collection, l'échange, la vente et la gradation de cartes. Événement caritatif.",
        image: "/images/events/pokheimon-300x100-1.png"
    },
    {
        id: 7,
        title: "Toulouse Game Show (TGS) 2025",
        date: "Novembre/Décembre 2025 (Dates à confirmer)",
        location: "Toulouse",
        description: "Événement pop culture avec une section dédiée aux TCG, incluant des stands de vente, des tournois et des animations.",
        image: "/images/events/toulouse_game_show.png" // Image locale pour le TGS 2025
    },

    {
        id: 9,
        title: "Paris Manga & Sci-Fi Show 2025 (Automne)",
        date: "Octobre/Novembre 2025 (Dates à confirmer)",
        location: "Paris",
        description: "Deuxième édition annuelle de cette convention populaire avec une section TCG pour les fans et les collectionneurs.",
        image: "/images/events/TGS_Paris_blanc test2.png"
    },
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