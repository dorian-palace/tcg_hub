<template>
  <div class="event-search">
    <div class="search-options mb-4">
      <div class="row">
        <div class="col-md-4">
          <div class="form-group">
            <label for="location">Localisation</label>
            <input
              type="text"
              id="location"
              class="form-control"
              v-model="searchParams.location"
              placeholder="Ville ou adresse"
              @input="updateGeocode"
            />
          </div>
        </div>
        <div class="col-md-2">
          <div class="form-group">
            <label for="radius">Distance (km)</label>
            <input
              type="range"
              id="radius"
              class="form-range"
              v-model.number="searchParams.radius"
              min="1"
              max="500"
              step="1"
              @input="search"
            />
            <div class="d-flex justify-content-between">
              <small>1 km</small>
              <small>{{ searchParams.radius }} km</small>
              <small>500 km</small>
            </div>
          </div>
        </div>
        <div class="col-md-2">
          <div class="form-group">
            <label for="game">Jeu</label>
            <select
              id="game"
              class="form-select"
              v-model="searchParams.gameId"
              @change="search"
            >
              <option value="">Tous les jeux</option>
              <option v-for="game in games" :key="game.id" :value="game.id">
                {{ game.name }}
              </option>
            </select>
          </div>
        </div>
        <div class="col-md-2">
          <div class="form-group">
            <label for="eventType">Type d'événement</label>
            <select
              id="eventType"
              class="form-select"
              v-model="searchParams.eventType"
              @change="search"
            >
              <option value="">Tous les types</option>
              <option value="tournament">Tournoi</option>
              <option value="casual_play">Jeu libre</option>
              <option value="trade">Échange</option>
              <option value="release">Sortie</option>
              <option value="other">Autre</option>
            </select>
          </div>
        </div>
        <div class="col-md-2">
          <div class="form-group">
            <label for="eventType">Tri par</label>
            <select
              id="sort"
              class="form-select"
              v-model="searchParams.sort"
              @change="search"
            >
              <option value="distance">Distance</option>
              <option value="date">Date</option>
              <option value="popularity">Popularité</option>
            </select>
          </div>
        </div>
      </div>
    </div>

    <div class="search-results-container">
      <div class="row">
        <div class="col-md-5">
          <div class="search-results">
            <div v-if="loading" class="text-center p-5">
              <div class="spinner-border" role="status">
                <span class="visually-hidden">Chargement...</span>
              </div>
            </div>
            <div v-else-if="events.length === 0" class="text-center p-5">
              <p>Aucun événement trouvé. Veuillez ajuster vos critères de recherche.</p>
            </div>
            <div v-else class="list-group">
              <a
                v-for="event in events"
                :key="event.id"
                href="#"
                class="list-group-item list-group-item-action"
                :class="{ active: selectedEvent && selectedEvent.id === event.id }"
                @click.prevent="selectEvent(event)"
              >
                <div class="d-flex w-100 justify-content-between">
                  <h5 class="mb-1">{{ event.title }}</h5>
                  <small>{{ formatDistance(event.distance) }}</small>
                </div>
                <p class="mb-1">{{ event.venue_name }} - {{ event.city }}</p>
                <div class="d-flex w-100 justify-content-between">
                  <small>{{ formatDateTime(event.start_datetime) }}</small>
                  <small>{{ event.game.name }} - {{ formatEventType(event.event_type) }}</small>
                </div>
              </a>
            </div>
          </div>
        </div>
        <div class="col-md-7">
          <div id="map" class="map-container"></div>
          <div v-if="selectedEvent" class="event-details mt-3 p-3 border rounded">
            <h4>{{ selectedEvent.title }}</h4>
            <div class="row">
              <div class="col-md-6">
                <p><strong>Lieu:</strong> {{ selectedEvent.venue_name }}</p>
                <p><strong>Adresse:</strong> {{ selectedEvent.address }}, {{ selectedEvent.city }}</p>
                <p><strong>Date:</strong> {{ formatDateTime(selectedEvent.start_datetime) }}</p>
                <p><strong>Jeu:</strong> {{ selectedEvent.game.name }}</p>
                <p><strong>Type:</strong> {{ formatEventType(selectedEvent.event_type) }}</p>
              </div>
              <div class="col-md-6">
                <p v-if="selectedEvent.entry_fee"><strong>Frais d'entrée:</strong> {{ selectedEvent.entry_fee }} €</p>
                <p v-if="selectedEvent.max_participants"><strong>Places:</strong> {{ selectedEvent.max_participants }}</p>
                <p><strong>Organisateur:</strong> {{ selectedEvent.organizer.name }}</p>
                <div v-if="selectedEvent.description">
                  <strong>Description:</strong>
                  <p>{{ selectedEvent.description }}</p>
                </div>
                <div class="mt-3">
                  <a :href="`/events/${selectedEvent.id}`" class="btn btn-primary">Voir les détails</a>
                  <a :href="`/events/${selectedEvent.id}/register`" class="btn btn-success ms-2">S'inscrire</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import mapboxgl from 'mapbox-gl';
import 'mapbox-gl/dist/mapbox-gl.css';
import axios from 'axios';

export default {
  name: 'EventSearch',
  data() {
    return {
      searchParams: {
        location: '',
        radius: 50,
        gameId: '',
        eventType: '',
        sort: 'distance',
        latitude: null,
        longitude: null
      },
      events: [],
      games: [],
      loading: false,
      map: null,
      markers: [],
      selectedEvent: null,
      geocodeTimeout: null
    };
  },
  async mounted() {
    // Fetch games for the dropdown
    try {
      const response = await axios.get('/api/games');
      this.games = response.data;
    } catch (error) {
      console.error('Error fetching games:', error);
    }

    // Initialize Mapbox
    mapboxgl.accessToken = window.mapboxToken || 'pk.YOUR_MAPBOX_TOKEN_HERE';
    
    this.map = new mapboxgl.Map({
      container: 'map',
      style: 'mapbox://styles/mapbox/streets-v11',
      center: [2.349014, 48.864716], // Paris by default
      zoom: 10
    });

    // Try to get user's location
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(
        position => {
          this.searchParams.latitude = position.coords.latitude;
          this.searchParams.longitude = position.coords.longitude;
          
          // Reverse geocode to get the address
          this.reverseGeocode(position.coords.latitude, position.coords.longitude);
          
          // Center the map on user location
          this.map.flyTo({
            center: [position.coords.longitude, position.coords.latitude],
            zoom: 10
          });
          
          // Search events with the user's location
          this.search();
        },
        error => {
          console.error('Error getting location:', error);
          // Use default location (Paris) if geolocation fails
          this.searchParams.latitude = 48.864716;
          this.searchParams.longitude = 2.349014;
          this.searchParams.location = 'Paris, France';
          this.search();
        }
      );
    } else {
      // Geolocation not supported, use default values
      this.searchParams.latitude = 48.864716;
      this.searchParams.longitude = 2.349014;
      this.searchParams.location = 'Paris, France';
      this.search();
    }
  },
  methods: {
    async search() {
      this.loading = true;
      
      try {
        // If we have location text but no coordinates, try to geocode first
        if (this.searchParams.location && (!this.searchParams.latitude || !this.searchParams.longitude)) {
          await this.geocode();
        }
        
        // Prepare search parameters
        const params = {
          latitude: this.searchParams.latitude,
          longitude: this.searchParams.longitude,
          radius: this.searchParams.radius
        };
        
        if (this.searchParams.gameId) {
          params.game_id = this.searchParams.gameId;
        }
        
        if (this.searchParams.eventType) {
          params.event_type = this.searchParams.eventType;
        }
        
        if (this.searchParams.sort) {
          params.sort = this.searchParams.sort;
        }
        
        // Make API request
        const response = await axios.get('/api/events/search', { params });
        this.events = response.data;
        
        // Update map markers
        this.updateMapMarkers();
      } catch (error) {
        console.error('Error searching events:', error);
      } finally {
        this.loading = false;
      }
    },
    
    // Debounce the geocode requests when typing in the location field
    updateGeocode() {
      if (this.geocodeTimeout) {
        clearTimeout(this.geocodeTimeout);
      }
      
      this.geocodeTimeout = setTimeout(() => {
        this.geocode();
      }, 500);
    },
    
    async geocode() {
      if (!this.searchParams.location) return;
      
      try {
        const response = await axios.get(`https://api.mapbox.com/geocoding/v5/mapbox.places/${encodeURIComponent(this.searchParams.location)}.json`, {
          params: {
            access_token: mapboxgl.accessToken,
            country: 'fr',
            limit: 1
          }
        });
        
        if (response.data.features && response.data.features.length > 0) {
          const [longitude, latitude] = response.data.features[0].center;
          this.searchParams.latitude = latitude;
          this.searchParams.longitude = longitude;
          
          // Center map on the new location
          this.map.flyTo({
            center: [longitude, latitude],
            zoom: 10
          });
          
          // Search events with the new coordinates
          this.search();
        }
      } catch (error) {
        console.error('Error geocoding location:', error);
      }
    },
    
    async reverseGeocode(latitude, longitude) {
      try {
        const response = await axios.get(`https://api.mapbox.com/geocoding/v5/mapbox.places/${longitude},${latitude}.json`, {
          params: {
            access_token: mapboxgl.accessToken,
            types: 'place',
            limit: 1
          }
        });
        
        if (response.data.features && response.data.features.length > 0) {
          this.searchParams.location = response.data.features[0].place_name;
        }
      } catch (error) {
        console.error('Error reverse geocoding:', error);
      }
    },
    
    updateMapMarkers() {
      // Remove existing markers
      this.markers.forEach(marker => marker.remove());
      this.markers = [];
      
      // Add new markers
      this.events.forEach(event => {
        // Create a marker element
        const el = document.createElement('div');
        el.className = 'map-marker';
        el.style.backgroundImage = 'url(/images/marker.png)';
        el.style.width = '32px';
        el.style.height = '32px';
        el.style.backgroundSize = 'cover';
        
        // Create the marker and add to map
        const marker = new mapboxgl.Marker(el)
          .setLngLat([event.longitude, event.latitude])
          .setPopup(new mapboxgl.Popup({ offset: 25 })
            .setHTML(`
              <h5>${event.title}</h5>
              <p>${event.venue_name}</p>
              <p>${this.formatDateTime(event.start_datetime)}</p>
              <a href="/events/${event.id}">Voir les détails</a>
            `))
          .addTo(this.map);
        
        // Store the marker reference
        this.markers.push(marker);
        
        // Add click event to select this event when clicking on the marker
        el.addEventListener('click', () => {
          this.selectEvent(event);
        });
      });
      
      // If we have results, fit the map to show all markers
      if (this.events.length > 0) {
        const bounds = new mapboxgl.LngLatBounds();
        this.events.forEach(event => {
          bounds.extend([event.longitude, event.latitude]);
        });
        
        this.map.fitBounds(bounds, { padding: 50, maxZoom: 15 });
      }
    },
    
    selectEvent(event) {
      this.selectedEvent = event;
      
      // Center the map on the selected event
      this.map.flyTo({
        center: [event.longitude, event.latitude],
        zoom: 14
      });
      
      // Highlight the marker for the selected event
      this.markers.forEach(marker => {
        const markerElement = marker.getElement();
        const markerCoordinates = marker.getLngLat();
        
        if (markerCoordinates.lng === event.longitude && markerCoordinates.lat === event.latitude) {
          markerElement.style.zIndex = 1;
          markerElement.style.transform = `${markerElement.style.transform} scale(1.2)`;
        } else {
          markerElement.style.zIndex = 0;
          markerElement.style.transform = markerElement.style.transform.replace(' scale(1.2)', '');
        }
      });
    },
    
    formatDistance(distance) {
      if (!distance) return '';
      return distance < 1 ? `${Math.round(distance * 1000)} m` : `${Math.round(distance * 10) / 10} km`;
    },
    
    formatDateTime(dateTimeString) {
      const date = new Date(dateTimeString);
      return date.toLocaleDateString('fr-FR', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
      });
    },
    
    formatEventType(type) {
      const typeMap = {
        'tournament': 'Tournoi',
        'casual_play': 'Jeu libre',
        'trade': 'Échange',
        'release': 'Sortie',
        'other': 'Autre'
      };
      
      return typeMap[type] || type;
    }
  }
};
</script>

<style scoped>
.event-search {
  margin-top: 20px;
}

.search-options {
  background-color: #f8f9fa;
  padding: 20px;
  border-radius: 5px;
  margin-bottom: 20px;
}

.map-container {
  height: 500px;
  border-radius: 5px;
  overflow: hidden;
}

.search-results {
  max-height: 500px;
  overflow-y: auto;
  border: 1px solid #dee2e6;
  border-radius: 5px;
}

.list-group-item.active {
  background-color: #0d6efd;
  border-color: #0d6efd;
}

.event-details {
  background-color: #f8f9fa;
}

@media (max-width: 768px) {
  .map-container {
    height: 300px;
    margin-top: 20px;
  }
  
  .search-results {
    max-height: 300px;
  }
}
</style>