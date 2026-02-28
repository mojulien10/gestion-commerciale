# 🎨 GUIDELINES & STYLE GUIDE - GESTION COMMERCIALE

> Guide de développement, conventions de code et style UI/UX du projet

**Dernière mise à jour** : 19 Février 2026  
**Auteur** : MOHAMED JULIEN NIASSY

---

## 📋 TABLE DES MATIÈRES

1. [Conventions de code](#conventions-de-code)
2. [Architecture Laravel](#architecture-laravel)
3. [Base de données](#base-de-données)
4. [Style UI/UX](#style-uiux)
5. [Composants réutilisables](#composants-réutilisables)
6. [JavaScript et interactivité](#javascript-et-interactivité)
7. [Gestion des erreurs](#gestion-des-erreurs)
8. [Performance](#performance)
9. [Git et versioning](#git-et-versioning)
10. [Documentation](#documentation)

---

## 💻 CONVENTIONS DE CODE

### **PHP / Laravel**

#### **Nommage**
```php
// ✅ CORRECT
class ClientController extends Controller { }
public function index() { }
$totalAchats = 0;
$clients = Client::all();

// ❌ INCORRECT
class clientcontroller extends Controller { }
public function Index() { }
$total_achats = 0;
$Clients = Client::all();
```

**Règles** :
- **Classes** : PascalCase (`ClientController`, `RecommendationService`)
- **Méthodes** : camelCase (`index()`, `calculerAssociations()`)
- **Variables** : camelCase (`$totalAchats`, `$clientId`)
- **Constantes** : SCREAMING_SNAKE_CASE (`TAX_RATE`, `MAX_ITEMS`)
- **Tables DB** : snake_case PLURIEL (`clients`, `lignes_vente`)
- **Colonnes DB** : snake_case (`total_achats`, `dernier_achat_le`)

#### **Structure Contrôleur**
```php
<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Afficher la liste des clients.
     */
    public function index(Request $request)
    {
        // 1. Récupération paramètres
        $search = $request->input('search');
        
        // 2. Requête base de données
        $clients = Client::query()
            ->when($search, function ($query, $search) {
                return $query->where('nom', 'like', "%{$search}%");
            })
            ->orderBy('nom', 'asc')
            ->get();
        
        // 3. Retour vue
        return view('clients.index', compact('clients', 'search'));
    }
    
    /**
     * Enregistrer un nouveau client.
     */
    public function store(Request $request)
    {
        // 1. Validation
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'telephone' => 'required|string|max:20|unique:clients,telephone',
            'email' => 'nullable|email|max:255',
            'adresse' => 'nullable|string',
        ]);
        
        // 2. Création
        $client = Client::create($validated);
        
        // 3. Redirection avec message
        return redirect()->route('clients.index')
            ->with('success', 'Client ajouté avec succès !');
    }
    
    // ... autres méthodes
}
```

#### **Structure Modèle**
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    /**
     * Table associée.
     */
    protected $table = 'clients';

    /**
     * Mass assignment.
     */
    protected $fillable = [
        'nom',
        'telephone',
        'email',
        'adresse',
        'total_achats',
        'nombre_achats',
        'dernier_achat_le',
    ];

    /**
     * Casting des attributs.
     */
    protected $casts = [
        'total_achats' => 'decimal:2',
        'nombre_achats' => 'integer',
        'dernier_achat_le' => 'datetime',
    ];
    
    /**
     * Relations.
     */
    public function ventes()
    {
        return $this->hasMany(Vente::class);
    }
}
```

#### **Validation**
```php
// ✅ Dans le contrôleur (simple)
$validated = $request->validate([
    'nom' => 'required|string|max:255',
    'email' => 'nullable|email',
]);

// ✅ Form Request (complexe) - À créer si nécessaire
php artisan make:request StoreClientRequest
```

#### **Commentaires**
```php
// ✅ CORRECT - Commentaires clairs et utiles
/**
 * Calculer les associations entre produits.
 * Utilise l'algorithme Apriori simplifié.
 * 
 * @return void
 */
public function calculerAssociations()
{
    // Récupération des ventes finalisées
    $ventes = Vente::where('statut', 'finalisee')->get();
    
    // Construction de la matrice produits
    foreach ($ventes as $vente) {
        // ...
    }
}

// ❌ INCORRECT - Commentaires évidents
// Boucle sur les clients
foreach ($clients as $client) {
    // Afficher le nom
    echo $client->nom;
}
```

---

## 🏛️ ARCHITECTURE LARAVEL

### **Organisation des fichiers**
```
app/
├── Http/
│   └── Controllers/
│       ├── ClientController.php        # CRUD clients
│       ├── ProduitController.php       # CRUD produits
│       └── VenteController.php         # Gestion ventes
│
├── Models/
│   ├── Client.php                      # Modèle client
│   ├── Produit.php                     # Modèle produit
│   └── Vente.php                       # Modèle vente
│
└── Services/                           # Logique métier complexe
    ├── RecommendationService.php       # Algorithme ⭐
    ├── StockService.php                # Gestion stock
    └── StatistiqueService.php          # Calculs stats
```

### **Quand créer un Service ?**

**✅ Créer un Service si** :
- Logique métier complexe (>50 lignes)
- Utilisé dans plusieurs contrôleurs
- Algorithme spécifique (recommandations)
- Calculs lourds (statistiques)

**❌ Rester dans le Contrôleur si** :
- CRUD simple
- Logique spécifique à une action
- Moins de 20 lignes

**Exemple** :
```php
// ❌ DANS LE CONTRÔLEUR (trop complexe)
public function index()
{
    // 50 lignes de calcul d'associations...
}

// ✅ DANS UN SERVICE
// VenteController.php
public function create()
{
    $recommandations = app(RecommendationService::class)
        ->recommanderPour($produitsSelectionnes);
    
    return view('ventes.create', compact('recommandations'));
}

// RecommendationService.php
public function recommanderPour(array $produitsIds)
{
    // Logique complexe ici
}
```

### **Routes**
```php
// routes/web.php

use App\Http\Controllers\ClientController;

// ✅ Routes resourceful (CRUD complet)
Route::middleware(['auth'])->group(function () {
    Route::resource('clients', ClientController::class);
    Route::resource('produits', ProduitController::class);
    Route::resource('ventes', VenteController::class);
});

// ✅ Routes custom si nécessaire
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/rapports', [RapportController::class, 'index'])->name('rapports.index');
    Route::post('/recommandations/calculer', [RecommendationController::class, 'calculer']);
});
```

---

## 🗄️ BASE DE DONNÉES

### **Nommage des tables**
```sql
-- ✅ CORRECT : snake_case, pluriel, français
clients
categories
produits
ventes
lignes_vente
mouvements_stock
associations_produits

-- ❌ INCORRECT
Client              -- Pas en majuscule
client              -- Pas au singulier
Clients_Table       -- Pas de majuscules
lignesVente         -- Pas de camelCase
```

### **Nommage des colonnes**
```sql
-- ✅ CORRECT : snake_case, français
nom
telephone
email
total_achats
nombre_achats
dernier_achat_le
categorie_id        -- FK avec _id

-- ❌ INCORRECT
Nom                 -- Pas de majuscule
totalAchats         -- Pas de camelCase
dernierAchat        -- Incomplet
```

### **Migrations**
```php
// ✅ CORRECT
public function up(): void
{
    Schema::create('clients', function (Blueprint $table) {
        $table->id();
        $table->string('nom');
        $table->string('telephone', 20)->unique();
        $table->string('email')->nullable();
        $table->text('adresse')->nullable();
        $table->decimal('total_achats', 15, 2)->default(0);
        $table->integer('nombre_achats')->default(0);
        $table->timestamp('dernier_achat_le')->nullable();
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('clients');
}
```

**Règles** :
- ✅ Toujours définir `down()` (rollback)
- ✅ Mettre des valeurs par défaut si pertinent
- ✅ `nullable()` pour champs optionnels
- ✅ `unique()` pour champs uniques
- ✅ Toujours `timestamps()` à la fin

### **Foreign Keys**
```php
// ✅ CORRECT
Schema::create('produits', function (Blueprint $table) {
    $table->id();
    $table->foreignId('categorie_id')
          ->constrained('categories')
          ->onDelete('cascade');
    // ...
});

// Ou version explicite
$table->unsignedBigInteger('categorie_id');
$table->foreign('categorie_id')
      ->references('id')
      ->on('categories')
      ->onDelete('cascade');
```

---

## 🎨 STYLE UI/UX

### **Palette de couleurs**

Basée sur DaisyUI + personnalisations :
```css
/* Couleurs principales */
--primary: #3B82F6      /* Bleu - Actions principales */
--secondary: #9333EA    /* Violet - Actions secondaires */
--accent: #F59E0B       /* Orange - Accents */
--success: #10B981      /* Vert - Succès */
--warning: #F59E0B      /* Orange - Attention */
--error: #EF4444        /* Rouge - Erreurs */
--info: #3B82F6         /* Bleu - Info */

/* Couleurs neutres */
--base-100: #FFFFFF     /* Fond carte */
--base-200: #F3F4F6     /* Fond page */
--base-300: #E5E7EB     /* Bordures */
--base-content: #1F2937 /* Texte principal */
```

### **Typographie**
```css
/* Tailles */
text-xs     /* 12px - Labels, descriptions */
text-sm     /* 14px - Texte secondaire */
text-base   /* 16px - Texte principal */
text-lg     /* 18px - Sous-titres */
text-xl     /* 20px - Titres sections */
text-2xl    /* 24px - Titres cartes */
text-3xl    /* 30px - Titres pages */
text-4xl    /* 36px - Noms, highlights */

/* Poids */
font-normal     /* 400 - Texte normal */
font-medium     /* 500 - Légèrement bold */
font-semibold   /* 600 - Labels */
font-bold       /* 700 - Titres */
font-black      /* 900 - Titres majeurs */
```

### **Spacing**
```css
/* Padding */
p-4         /* 1rem = 16px - Cards internes */
p-6         /* 1.5rem = 24px - Cards principales */
py-8        /* 2rem vertical = 32px - Pages */

/* Margin */
mb-6        /* 1.5rem bottom - Entre sections */
gap-6       /* 1.5rem - Grids */
space-x-3   /* 0.75rem - Éléments inline */

/* Règle : Toujours multiples de 4 (4, 8, 12, 16, 24, 32...) */
```

### **Rounded Corners**
```css
rounded-lg      /* 8px - Boutons, badges */
rounded-xl      /* 12px - Cards */
rounded-2xl     /* 16px - Sections internes */
rounded-3xl     /* 24px - Empty states */
rounded-full    /* 9999px - Avatars, pills */
```

### **Shadows**
```css
shadow-sm       /* Subtile - Bordures alternatives */
shadow          /* Standard - Éléments surélevés */
shadow-lg       /* Large - Modals, dropdowns */
shadow-xl       /* Extra large - Cards principales */
```

---

## 🧩 COMPOSANTS RÉUTILISABLES

### **1. Layout de base**
```blade
<!-- resources/views/layouts/app.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-3xl font-bold text-base-content">
                🎯 Titre de la Page
            </h2>
            <a href="#" class="btn btn-primary gap-2">
                <svg>...</svg>
                Action Principale
            </a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Contenu -->
    </div>
</x-app-layout>
```

### **2. Message de succès**
```blade
@if(session('success'))
    <div class="alert alert-success shadow-lg mb-6">
        <div>
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    </div>
@endif
```

### **3. Message d'erreur**
```blade
@if ($errors->any())
    <div class="alert alert-error shadow-lg mb-6">
        <div class="flex-1">
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <div>
                <h3 class="font-bold text-error-content">Erreurs de validation</h3>
                <ul class="list-disc list-inside text-error-content mt-2">
                    @foreach ($errors->all() as $error)
                        <li class="text-sm">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif
```

### **4. Avatar avec initiale**
```blade
<div class="avatar placeholder">
    <div class="bg-primary text-primary-content rounded-full w-12 h-12 flex items-center justify-center">
        <span class="text-xl font-bold">{{ strtoupper(substr($nom, 0, 1)) }}</span>
    </div>
</div>
```

### **5. Section info avec background**
```blade
<div class="bg-base-200/50 p-4 rounded-2xl">
    <label class="text-xs font-bold uppercase text-base-content/50">Téléphone</label>
    <div class="mt-1">
        <span class="text-xl font-semibold">{{ $telephone }}</span>
    </div>
</div>
```

### **6. Stat card colorée**
```blade
<div class="stat bg-primary text-primary-content rounded-2xl shadow-xl">
    <div class="stat-title text-primary-content/70">Nombre d'achats</div>
    <div class="stat-value text-3xl">{{ $nombre }}</div>
    <div class="stat-desc text-primary-content/60">Total cumulé</div>
</div>
```

### **7. Empty state**
```blade
<div class="text-center py-12 bg-base-200/30 rounded-3xl border-2 border-dashed border-base-300">
    <div class="text-5xl mb-4">📦</div>
    <p class="text-base-content/60 font-medium">Aucune donnée disponible</p>
    <p class="text-xs text-base-content/40 mt-2">Les données apparaîtront ici automatiquement</p>
</div>
```

### **8. Formulaire type**
```blade
<form action="{{ route('clients.store') }}" method="POST">
    @csrf
    
    <!-- Champ texte -->
    <div class="form-control w-full">
        <label class="label">
            <span class="label-text font-semibold">Nom <span class="text-error">*</span></span>
        </label>
        <input 
            type="text" 
            name="nom" 
            value="{{ old('nom') }}"
            placeholder="Ex: Amadou Diallo" 
            class="input input-bordered w-full @error('nom') input-error @enderror" 
            required
        />
        @error('nom')
            <label class="label">
                <span class="label-text-alt text-error">{{ $message }}</span>
            </label>
        @enderror
    </div>
    
    <!-- Textarea -->
    <div class="form-control w-full mt-4">
        <label class="label">
            <span class="label-text font-semibold">Adresse <span class="text-base-content/50">(optionnel)</span></span>
        </label>
        <textarea 
            name="adresse" 
            rows="3"
            placeholder="Ex: Médina, Rue 15, Dakar" 
            class="textarea textarea-bordered w-full @error('adresse') input-error @enderror"
        >{{ old('adresse') }}</textarea>
    </div>
    
    <!-- Boutons -->
    <div class="card-actions justify-end mt-8">
        <a href="{{ route('clients.index') }}" class="btn btn-ghost">
            Annuler
        </a>
        <button type="submit" class="btn btn-primary gap-2">
            <svg>...</svg>
            Enregistrer
        </button>
    </div>
</form>
```

### **9. Tableau avec actions**
```blade
<div class="overflow-x-auto">
    <table class="table table-zebra w-full">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Email</th>
                <th class="text-right">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
                <tr class="hover">
                    <td>{{ $item->nom }}</td>
                    <td>{{ $item->email }}</td>
                    <td class="text-right">
                        <div class="join">
                            <a href="{{ route('items.show', $item->id) }}" class="btn btn-xs join-item">👁️</a>
                            <a href="{{ route('items.edit', $item->id) }}" class="btn btn-xs join-item">✏️</a>
                            <form action="{{ route('items.destroy', $item->id) }}" method="POST" class="inline join-item">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-xs btn-error" onclick="return confirm('Supprimer ?')">🗑️</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
```

---

## ⚡ JAVASCRIPT ET INTERACTIVITÉ

### **Alpine.js (inclus avec Breeze)**
```blade
<!-- Dropdown simple -->
<div x-data="{ open: false }">
    <button @click="open = !open" class="btn">Menu</button>
    <div x-show="open" @click.outside="open = false">
        <!-- Contenu dropdown -->
    </div>
</div>

<!-- Modal -->
<div x-data="{ showModal: false }">
    <button @click="showModal = true" class="btn">Ouvrir</button>
    
    <div x-show="showModal" class="modal modal-open">
        <div class="modal-box">
            <h3>Titre</h3>
            <p>Contenu</p>
            <div class="modal-action">
                <button @click="showModal = false" class="btn">Fermer</button>
            </div>
        </div>
    </div>
</div>
```

### **AJAX (pour recommandations)**
```javascript
// Exemple panier vente avec recommandations
document.addEventListener('DOMContentLoaded', function() {
    const panierProduits = [];
    
    // Ajouter produit au panier
    function ajouterProduit(produitId) {
        panierProduits.push(produitId);
        
        // Récupérer recommandations via AJAX
        fetch('/api/recommandations', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ produits: panierProduits })
        })
        .then(response => response.json())
        .then(data => {
            afficherRecommandations(data.recommandations);
        });
    }
    
    function afficherRecommandations(recos) {
        const container = document.getElementById('recommandations');
        container.innerHTML = '';
        
        recos.forEach(reco => {
            const div = document.createElement('div');
            div.className = 'bg-info/10 p-4 rounded-2xl';
            div.innerHTML = `
                <p class="font-bold">${reco.nom}</p>
                <p class="text-sm">${reco.confiance * 100}% des clients</p>
                <button onclick="ajouterRecommandation(${reco.id})" class="btn btn-sm btn-primary mt-2">
                    Ajouter
                </button>
            `;
            container.appendChild(div);
        });
    }
});
```

---

## 🚨 GESTION DES ERREURS

### **Messages utilisateur**
```php
// ✅ Messages clairs et informatifs
return redirect()->back()
    ->with('error', 'Ce numéro de téléphone est déjà utilisé.');

// ❌ Messages techniques
return redirect()->back()
    ->with('error', 'SQLSTATE[23000]: Integrity constraint violation');
```

### **Try-Catch**
```php
// ✅ Pour opérations critiques
try {
    DB::transaction(function () use ($request) {
        $vente = Vente::create([...]);
        foreach ($produits as $produit) {
            LigneVente::create([...]);
            $produit->decrement('stock_actuel', $quantite);
        }
    });
    
    return redirect()->route('ventes.index')
        ->with('success', 'Vente enregistrée avec succès !');
        
} catch (\Exception $e) {
    Log::error('Erreur création vente : ' . $e->getMessage());
    
    return redirect()->back()
        ->with('error', 'Une erreur est survenue. Veuillez réessayer.')
        ->withInput();
}
```

---

## ⚡ PERFORMANCE

### **Eager Loading**
```php
// ❌ N+1 Query Problem
$clients = Client::all();
foreach ($clients as $client) {
    echo $client->ventes->count(); // 1 requête par client !
}

// ✅ Eager Loading
$clients = Client::with('ventes')->get();
foreach ($clients as $client) {
    echo $client->ventes->count(); // 1 seule requête supplémentaire
}
```

### **Pagination**
```php
// ✅ Pour listes longues
$produits = Produit::paginate(20);

// Dans la vue
{{ $produits->links() }}
```

### **Cache (si nécessaire)**
```php
// Pour données peu changeantes
$categories = Cache::remember('categories', 3600, function () {
    return Categorie::all();
});
```

---

## 📁 GIT ET VERSIONING

### **Messages de commit**
```bash
# ✅ CORRECT - Descriptif et clair
git commit -m "Ajout recherche clients par nom et téléphone"
git commit -m "Correction bug calcul total panier"
git commit -m "Session 4: Module Catégories complet"

# ❌ INCORRECT - Trop vague
git commit -m "update"
git commit -m "fix"
git commit -m "changes"
```

### **Structure des commits**
```bash
# Par session
git add .
git commit -m "Session X: Description module"
git push origin main
```

### **.gitignore**
```
# Déjà inclus par défaut Laravel
/node_modules
/public/hot
/public/storage
/storage/*.key
/vendor
.env
.env.backup
.phpunit.result.cache
npm-debug.log
yarn-error.log

# Ajouts spécifiques
.DS_Store
Thumbs.db
*.log
```

---

## 📖 DOCUMENTATION

### **Commentaires de code**
```php
/**
 * Calculer les associations entre produits.
 * 
 * Utilise l'algorithme Apriori simplifié pour identifier
 * les produits fréquemment achetés ensemble.
 * 
 * @return void
 */
public function calculerAssociations()
{
    // Code...
}
```

### **README.md**

Doit contenir :
- Description du projet
- Installation
- Configuration
- Utilisation
- Technologies utilisées
- Captures d'écran
- Lien GitHub

### **CHANGELOG (optionnel)**
```markdown
# CHANGELOG

## [1.0.0] - 2026-04-01
### Ajouté
- Module clients complet
- Module produits avec gestion stock
- Module ventes avec recommandations
- Dashboard avec KPIs

### Corrigé
- Bug calcul panier moyen
- Affichage mobile navbar
```

---

## ✅ CHECKLIST AVANT COMMIT

- [ ] Code testé manuellement
- [ ] Pas d'erreurs console
- [ ] Messages de succès/erreur affichés
- [ ] Responsive vérifié (mobile)
- [ ] Pas de `dd()` ou `var_dump()` oubliés
- [ ] Commentaires ajoutés si logique complexe
- [ ] .env.example mis à jour si nouvelles variables
- [ ] Git commit message descriptif

---

## 🎯 BONNES PRATIQUES GÉNÉRALES

### **DRY (Don't Repeat Yourself)**
```blade
<!-- ❌ Répétition -->
<div class="bg-base-200/50 p-4 rounded-2xl">...</div>
<div class="bg-base-200/50 p-4 rounded-2xl">...</div>
<div class="bg-base-200/50 p-4 rounded-2xl">...</div>

<!-- ✅ Component Blade -->
@component('components.info-box', ['label' => 'Téléphone', 'value' => $telephone])
@endcomponent
```

### **KISS (Keep It Simple, Stupid)**
```php
// ❌ Over-engineering
public function getNomComplet()
{
    return ucwords(strtolower(trim($this->prenom . ' ' . $this->nom)));
}

// ✅ Simple et clair
public function getNomComplet()
{
    return $this->nom; // Si déjà formaté en BDD
}
```

### **YAGNI (You Aren't Gonna Need It)**

Ne pas coder de fonctionnalités "au cas où".

❌ N'ajoutez pas :
- Système de permissions complexe si pas demandé
- Export en 10 formats différents
- API REST si pas utilisée

✅ Ajoutez seulement ce qui est spécifié dans le cahier des charges.

---

## 📞 RESSOURCES

**Documentation officielle** :
- Laravel : https://laravel.com/docs
- Tailwind CSS : https://tailwindcss.com/docs
- DaisyUI : https://daisyui.com/components
- Alpine.js : https://alpinejs.dev

**Outils utiles** :
- Tailwind Play : https://play.tailwindcss.com (tester CSS)
- PHP Storm / VS Code (IDE)
- Laravel Debugbar (débogage)

---

**Dernière mise à jour** : 19 Février 2026  
**Auteur** : MOHAMED JULIEN NIASSY  
**Projet** : Gestion Commerciale avec Recommandations Intelligentes