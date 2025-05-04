<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Comment;
use App\Models\Event;
use App\Models\User;
use Carbon\Carbon;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupérer tous les événements et utilisateurs
        $events = Event::all();
        $users = User::all();

        if ($events->isEmpty() || $users->isEmpty()) {
            $this->command->info('Aucun événement ou utilisateur trouvé. Veuillez d\'abord exécuter les seeders EventSeeder et UserSeeder.');
            return;
        }

        // Phrases pour les commentaires
        $commentPhrases = [
            'Super événement ! J\'ai hâte d\'y participer.',
            'Je serai là avec quelques amis.',
            'Quel est le format du tournoi ?',
            'Est-ce qu\'il y aura des prix ?',
            'Je suis nouveau dans le jeu, est-ce que c\'est adapté pour les débutants ?',
            'Quel deck recommandez-vous pour cet événement ?',
            'Je viendrai avec ma collection pour les échanges.',
            'Est-ce qu\'il y aura de la nourriture sur place ?',
            'Je peux aider à l\'organisation si besoin.',
            'Quel est le niveau moyen des participants ?',
            'Je suis intéressé par les échanges de cartes rares.',
            'Est-ce qu\'il y aura des démonstrations pour les nouveaux joueurs ?',
            'Je viendrai avec mon deck compétitif.',
            'Quel est le prix d\'entrée ?',
            'Je peux apporter des tables supplémentaires si nécessaire.',
            'Est-ce qu\'il y aura un système de jumelage ?',
            'Je suis disponible pour arbitrer si besoin.',
            'Quel est le format de deck autorisé ?',
            'Je viendrai avec des cartes à vendre.',
            'Est-ce qu\'il y aura des goodies ?'
        ];

        // Réponses possibles
        $replyPhrases = [
            'Oui, bien sûr !',
            'Merci pour votre intérêt !',
            'Je vais vous répondre en MP.',
            'C\'est noté, merci !',
            'Je vous envoie les détails.',
            'N\'hésitez pas à me contacter.',
            'Je vous remercie de votre proposition.',
            'Je vais mettre à jour les informations.',
            'C\'est une excellente question !',
            'Je vous tiendrai au courant.'
        ];

        // Créer des commentaires pour chaque événement
        foreach ($events as $event) {
            // Nombre aléatoire de commentaires par événement (entre 3 et 8)
            $numComments = rand(3, 8);
            
            for ($i = 0; $i < $numComments; $i++) {
                // Sélectionner un utilisateur aléatoire
                $user = $users->random();
                
                // Créer le commentaire principal
                $comment = Comment::create([
                    'user_id' => $user->id,
                    'event_id' => $event->id,
                    'content' => $commentPhrases[array_rand($commentPhrases)],
                    'created_at' => Carbon::now()->subDays(rand(1, 30)),
                    'updated_at' => Carbon::now()->subDays(rand(1, 30))
                ]);

                // 50% de chance d'avoir des réponses
                if (rand(0, 1)) {
                    // Nombre aléatoire de réponses (entre 1 et 3)
                    $numReplies = rand(1, 3);
                    
                    for ($j = 0; $j < $numReplies; $j++) {
                        // Sélectionner un utilisateur différent pour la réponse
                        $replyUser = $users->where('id', '!=', $user->id)->random();
                        
                        Comment::create([
                            'user_id' => $replyUser->id,
                            'event_id' => $event->id,
                            'parent_id' => $comment->id,
                            'content' => $replyPhrases[array_rand($replyPhrases)],
                            'created_at' => $comment->created_at->addMinutes(rand(5, 60)),
                            'updated_at' => $comment->created_at->addMinutes(rand(5, 60))
                        ]);
                    }
                }
            }
        }

        $this->command->info('CommentSeeder terminé avec succès !');
    }
}
