<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entree extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'entree'; // Assurez-vous de définir le nom de votre table si ce n'est pas le modèle Laravel par défaut

    protected $fillable = [ 'montant' ,	'date' ,	'id_utilisateur' ,	'id_candidat' 	,'id_type_paiement' 	]; // Liste des colonnes que vous pouvez remplir

     // Méthode pour obtenir la somme de tous les montants des entrées
    public static function sommeEntrees()
    {
        $totalEntrees = Entree::sum('montant');
    
        return view('partials.caisse', ['total' => $totalEntrees]);
    }

    // Méthode pour obtenir toutes les entrées payées
    public static function entreesPayees()
    {
        return self::where('paye', true)->get();
    }

    // Méthode pour ajouter une nouvelle entrée
    public static function ajouterEntree($montant, $autreColonne)
    {


        return self::create([
            'montant' => $montant,
            // 'date' => $date,
            // 'id_utilisateur' => $id_utilisateur,
            // 'id_candidat' => $id_candidat, 
            // 'id_type_paiement'=> $id_type_paiement,
           
        ]);
    }

    // Méthode pour mettre à jour une entrée existante
    public static function mettreAJourEntree($id, $montant, $autreColonne)
    {
        $entree = self::find($id);

        if ($entree) {
            $entree->update([
                'montant' => $montant,
                'autre_colonne' => $autreColonne,
                // Ajoutez d'autres colonnes si nécessaire
            ]);

            return $entree;
        }

        return null; // Ou vous pouvez jeter une exception ou traiter d'une autre manière si l'entrée n'est pas trouvée
    }

    // Méthode pour supprimer une entrée
    public static function supprimerEntree($id)
    {
        return self::destroy($id);
    }

    public function utilisateur()
    {
        return $this->belongsTo(User::class, 'id_utilisateur');
    }

    public function candidat()
    {
        return $this->belongsTo(Candidat::class, 'id_candidat', 'id');
    }

    public function typePaiement()
    {
        return $this->belongsTo(TypePaiement::class, 'id_type_paiement');
    }
}
