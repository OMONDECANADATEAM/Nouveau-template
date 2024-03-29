<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'last_name',
        'name',
        'email',
        'password',
        'id_poste_occupe',
        'id_role_utilisateur',
        'id_succursale',
        'lien_photo',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function posteOccupe()
    {
        return $this->belongsTo(PosteOccupe::class, 'id_poste_occupe');
    }

    public function candidat()
    {

        return $this->hasOne(Candidat::class);
    }

    public function succursale()
    {
        return $this->belongsTo(Succursale::class, 'id_succursale');
    }

    public function poste()
    {
        return $this->id_poste_occupe;
    
        }

    public function isUserSimple()
    {
        return $this->id_poste_occupe === 1;
    }

    /**
     * Vérifie si l'utilisateur est un consultant.
     *
     * @return bool
     */
    public function isConsultant()
    {
        return $this->id_poste_occupe === 0;
    }

    /**
     * Vérifie si l'utilisateur est un administrateur.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->id_poste_occupe === 3;
    }

    public function isResp()
    { {
            return $this->id_poste_occupe === 2;
        }
    }



    /**
     * Récupère le rôle de l'utilisateur (0, 1, 2).
     *
     * @return int
     */
    public function getRole()
    {
        return $this->id_role_utilisateur;
    }

    public function getUsersByRole($roleId)
    {
        // Utilisez Eloquent pour récupérer les utilisateurs ayant le rôle spécifié
        $utilisateurs = User::where('id_role_utilisateur', $roleId)->get();

        return $utilisateurs;
    }

    public function rendezVous()
    {
        return $this->hasMany(RendezVous::class, 'commercial_id');
    }
    public function candidats()
    {
        return $this->hasMany(Candidat::class, 'id_utilisateur');
    }
    
}
