<?php
namespace App\Console\Commands;

use App\Models\Emprunt;
use App\Notifications\NotificationEmail;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckLateReturns extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:retard';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Marquer les emprunts en retard';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::now();

        $empruntsEnRetard = Emprunt::with(['user', 'exemplaire.book'])
            ->where('date_retour_prevue', '<', $today)
            ->whereNull('date_retour_effectif')
            ->where('status', '!=', 'retard')
            ->get();

        $this->info("Nombre d'emprunts en retard trouvés : " . $empruntsEnRetard->count());

        foreach ($empruntsEnRetard as $emprunt) {
            try {
                $emprunt->update(['status' => 'retard']);

                $dateRetourPrevue = $emprunt->date_retour_prevue instanceof Carbon
                ? $emprunt->date_retour_prevue
                : Carbon::parse($emprunt->date_retour_prevue);

                $bookTitle  = $emprunt->exemplaire->book->title;
                $returnDate = $dateRetourPrevue->format('d/m/Y');
                $daysLate   = $today->diffInDays($dateRetourPrevue);

                $message = "Vous avez un retard de retourner le livre '{$bookTitle}'. ";
                $message .= "La date de retour prévue était : {$returnDate} (Retard de {$daysLate} jour(s)).";

                $emprunt->user->notify(new NotificationEmail(
                    message: $message,
                    bookTitle: $bookTitle,
                    actionUrl: route('client.emprunt.show', $emprunt->id),
                    actionText: 'Voir mes emprunts'
                ));

                $this->info("Notification envoyée à: " . $emprunt->user->email);

            } catch (\Exception $e) {
                $this->error("Erreur lors du traitement de l'emprunt ID {$emprunt->id}: " . $e->getMessage());
                \Log::error("Erreur traitement retard", [
                    'emprunt_id' => $emprunt->id,
                    'error'      => $e->getMessage(),
                ]);
            }
        }

        $this->info("Nombre d'emprunts mis à jour : " . $empruntsEnRetard->count());
        $this->info("Fin de commande.");
    }
}
