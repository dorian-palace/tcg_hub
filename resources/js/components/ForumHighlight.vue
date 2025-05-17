<template>
  <div class="forum-highlight bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 text-white rounded-xl shadow-2xl p-8 flex flex-col md:flex-row items-center justify-between mb-12 animate-fade-in relative overflow-hidden">
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_50%_120%,rgba(120,119,198,0.3),rgba(255,255,255,0))]"></div>
    <div class="flex items-center gap-6 relative z-10">
      <div class="flex-shrink-0">
        <i class="fas fa-comments fa-3x text-indigo-400"></i>
      </div>
      <div>
        <h2 class="text-2xl md:text-3xl font-bold mb-2 bg-clip-text text-transparent bg-gradient-to-r from-white to-gray-300">Découvrez notre Forum Communautaire !</h2>
        <p class="text-lg mb-2 text-gray-300">Partagez, échangez, posez vos questions et trouvez des réponses avec la communauté TCGalaxy.</p>
        <div class="flex gap-4 mt-2">
          <span class="bg-white/10 backdrop-blur-sm px-4 py-2 rounded-lg text-lg font-semibold flex items-center gap-2 border border-white/20">
            <i class="fas fa-layer-group text-indigo-400"></i> {{ forumsCount }} forums
          </span>
          <span class="bg-white/10 backdrop-blur-sm px-4 py-2 rounded-lg text-lg font-semibold flex items-center gap-2 border border-white/20">
            <i class="fas fa-comments text-indigo-400"></i> {{ topicsCount }} sujets
          </span>
        </div>
      </div>
    </div>
    <div class="mt-6 md:mt-0 relative z-10">
      <a :href="forumUrl" class="inline-block px-8 py-4 bg-indigo-600 text-white font-bold rounded-lg shadow-lg hover:bg-indigo-500 transition-all duration-300 text-xl hover:shadow-indigo-500/25 hover:scale-105">
        Accéder au forum
      </a>
    </div>
  </div>
</template>

<script>
export default {
  name: 'ForumHighlight',
  props: {
    forumsCount: {
      type: Number,
      required: true
    },
    topicsCount: {
      type: Number,
      required: true
    },
    forumUrl: {
      type: String,
      default: '/forums'
    }
  }
}
</script>

<style scoped>
@keyframes fade-in {
  from { opacity: 0; transform: translateY(30px); }
  to { opacity: 1; transform: translateY(0); }
}
.animate-fade-in {
  animation: fade-in 0.8s cubic-bezier(.4,0,.2,1) both;
}
</style> 