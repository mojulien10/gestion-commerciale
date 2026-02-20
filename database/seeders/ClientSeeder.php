<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Client;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        $clients = [
            ['nom' => 'Amadou Diallo', 'telephone' => '77 123 45 67', 'email' => 'amadou.diallo@email.com', 'adresse' => 'Médina, Rue 10, Dakar'],
            ['nom' => 'Fatou Sall', 'telephone' => '76 234 56 78', 'email' => 'fatou.sall@email.com', 'adresse' => 'Plateau, Avenue Pompidou, Dakar'],
            ['nom' => 'Ousmane Ba', 'telephone' => '70 345 67 89', 'email' => 'ousmane.ba@email.com', 'adresse' => 'Sacré-Cœur, Villa 234, Dakar'],
            ['nom' => 'Aissatou Ndiaye', 'telephone' => '77 456 78 90', 'email' => 'aissatou.ndiaye@email.com', 'adresse' => 'Mermoz, Rue 45, Dakar'],
            ['nom' => 'Ibrahima Sarr', 'telephone' => '76 567 89 01', 'email' => 'ibrahima.sarr@email.com', 'adresse' => 'Ouakam, Cité Asecna, Dakar'],
            ['nom' => 'Aminata Fall', 'telephone' => '70 678 90 12', 'email' => null, 'adresse' => 'Parcelles Assainies, Unité 15, Dakar'],
            ['nom' => 'Cheikh Sy', 'telephone' => '77 789 01 23', 'email' => 'cheikh.sy@email.com', 'adresse' => null],
            ['nom' => 'Khadija Diop', 'telephone' => '76 890 12 34', 'email' => 'khadija.diop@email.com', 'adresse' => 'Grand Yoff, Rue 25, Dakar'],
            ['nom' => 'Moussa Gueye', 'telephone' => '70 901 23 45', 'email' => 'moussa.gueye@email.com', 'adresse' => 'HLM Grand Yoff, Villa 89, Dakar'],
            ['nom' => 'Ndeye Thiam', 'telephone' => '77 012 34 56', 'email' => null, 'adresse' => 'Liberté 6, Extension, Dakar'],
            ['nom' => 'Mamadou Diouf', 'telephone' => '76 123 45 67', 'email' => 'mamadou.diouf@email.com', 'adresse' => 'Fann Résidence, Rue 12, Dakar'],
            ['nom' => 'Mariama Kane', 'telephone' => '70 234 56 78', 'email' => 'mariama.kane@email.com', 'adresse' => 'Point E, Rue 8, Dakar'],
            ['nom' => 'Ablaye Seck', 'telephone' => '77 345 67 89', 'email' => null, 'adresse' => 'Ngor, Almadies, Dakar'],
            ['nom' => 'Awa Cissé', 'telephone' => '76 456 78 90', 'email' => 'awa.cisse@email.com', 'adresse' => 'Yoff Layenne, Rue 34, Dakar'],
            ['nom' => 'Babacar Ndao', 'telephone' => '70 567 89 01', 'email' => 'babacar.ndao@email.com', 'adresse' => 'Dieuppeul, Derklé, Dakar'],
            ['nom' => 'Coumba Diagne', 'telephone' => '77 678 90 12', 'email' => 'coumba.diagne@email.com', 'adresse' => null],
            ['nom' => 'Demba Wade', 'telephone' => '76 789 01 23', 'email' => null, 'adresse' => 'Sicap Liberté, Villa 156, Dakar'],
            ['nom' => 'Fama Mbaye', 'telephone' => '70 890 12 34', 'email' => 'fama.mbaye@email.com', 'adresse' => 'Cambérène, Rue 67, Dakar'],
            ['nom' => 'Gorgui Diatta', 'telephone' => '77 901 23 45', 'email' => 'gorgui.diatta@email.com', 'adresse' => 'Pikine, Guédiawaye, Dakar'],
            ['nom' => 'Hawa Sow', 'telephone' => '76 012 34 56', 'email' => 'hawa.sow@email.com', 'adresse' => 'Rufisque, Quartier Arafat, Dakar'],
        ];

        foreach ($clients as $clientData) {
            Client::create($clientData);
        }
    }
}