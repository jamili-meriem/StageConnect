@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto">

    <div class="mb-8 text-center">
        <div class="w-16 h-16 btn-primary rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
            <span class="text-3xl">🤖</span>
        </div>
        <h1 class="text-2xl font-bold text-gray-800 mb-2">
            Offres recommandées par l'IA
        </h1>
        <p class="text-gray-500 text-sm">
            Décrivez votre profil et l'IA vous recommande les meilleures offres
        </p>
    </div>

    {{-- Formulaire profil --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8 mb-8">
        <div class="space-y-5">

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Vos compétences <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    id="competences"
                    placeholder="Ex: PHP, Laravel, MySQL, Python..."
                    class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300"
                >
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Domaine préféré <span class="text-red-500">*</span>
                </label>
                <select
                    id="domaine"
                    class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300"
                >
                    <option value="">-- Choisir un domaine --</option>
                    <option value="informatique">Informatique</option>
                    <option value="marketing">Marketing</option>
                    <option value="finance">Finance</option>
                    <option value="rh">Ressources humaines</option>
                    <option value="design">Design</option>
                    <option value="autre">Autre</option>
                </select>
            </div>

            <button onclick="obtenirRecommandations()"
                    id="btn-recommander"
                    class="w-full btn-primary text-white py-3 rounded-xl font-medium shadow-sm text-sm">
                Obtenir mes recommandations IA
            </button>

            <div id="loading" class="hidden text-center py-4">
                <div class="inline-flex items-center gap-2 text-blue-600 text-sm">
                    <svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                    </svg>
                    L'IA analyse votre profil...
                </div>
            </div>

        </div>
    </div>

    {{-- Résultats --}}
    <div id="resultats" class="hidden">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">
            Les meilleures offres pour votre profil
        </h2>
        <div id="liste-offres" class="space-y-4"></div>
    </div>

</div>

<script>
async function obtenirRecommandations() {
    const competences = document.getElementById('competences').value.trim();
    const domaine     = document.getElementById('domaine').value;
    const btn         = document.getElementById('btn-recommander');
    const loading     = document.getElementById('loading');
    const resultats   = document.getElementById('resultats');

    if (!competences || !domaine) {
        alert('Veuillez remplir tous les champs.');
        return;
    }

    btn.disabled = true;
    btn.classList.add('opacity-50');
    loading.classList.remove('hidden');
    resultats.classList.add('hidden');

    try {
        const response = await fetch('{{ route("ia.recommander") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: JSON.stringify({ competences, domaine }),
        });

        const data = await response.json();

        if (data.success) {
            const liste = document.getElementById('liste-offres');
            liste.innerHTML = '';

            // On itère sur les recommandations
            data.recommandations.forEach((rec, index) => {

                // On cherche l'offre correspondante dans data.offres
                // en comparant les IDs en string pour éviter les problèmes de type
                const offre = data.offres.find(o => String(o.id) === String(rec.id));

                // Si l'offre n'est pas trouvée on passe
                if (!offre) return;

                // Construction de l'URL correcte avec l'ID réel de l'offre
                const url = `/etudiant/offres/${offre.id}`;
                const urlPostuler = `/etudiant/offres/${offre.id}/postuler`;

                liste.innerHTML += `
                    <div style="background:white;border-radius:16px;border:1px solid #e2e8f0;padding:24px;box-shadow:0 2px 8px rgba(0,0,0,0.04);">

                        <div style="display:flex;justify-content:space-between;align-items:start;margin-bottom:12px;">
                            <div style="flex:1;">
                                <div style="display:flex;align-items:center;gap:8px;margin-bottom:8px;">
                                    <span style="background:#eff6ff;color:#1d4ed8;font-size:11px;font-weight:600;padding:4px 10px;border-radius:20px;">
                                        #${index + 1} Recommandé
                                    </span>
                                    <span style="background:#f0fdf4;color:#16a34a;font-size:11px;font-weight:500;padding:4px 10px;border-radius:20px;">
                                        ${offre.domaine}
                                    </span>
                                </div>
                                <h3 style="font-size:16px;font-weight:600;color:#1e293b;margin:0 0 4px;">
                                    ${offre.titre}
                                </h3>
                                <p style="font-size:13px;color:#3b82f6;margin:0;">
                                    ${offre.entreprise.name} — ${offre.lieu}
                                </p>
                            </div>
                        </div>

                        {{-- Raison de la recommandation --}}
                        <div style="background:#f8fafc;border-radius:10px;padding:12px;margin-bottom:16px;border-left:3px solid #3b82f6;">
                            <p style="font-size:13px;color:#475569;margin:0;line-height:1.6;">
                                <strong style="color:#1e40af;">Pourquoi cette offre :</strong>
                                ${rec.raison}
                            </p>
                        </div>

                        {{-- Boutons --}}
                        <div style="display:flex;gap:8px;">
                            <a href="${url}"
                               style="flex:1;display:block;text-align:center;background:linear-gradient(135deg,#1e40af,#3b82f6);color:white;padding:10px 20px;border-radius:10px;font-size:13px;font-weight:500;text-decoration:none;">
                                Voir l'offre
                            </a>
                            <a href="${urlPostuler}"
                               style="flex:1;display:block;text-align:center;background:white;color:#1e40af;padding:10px 20px;border-radius:10px;font-size:13px;font-weight:500;text-decoration:none;border:1px solid #bfdbfe;">
                                Postuler maintenant
                            </a>
                        </div>

                    </div>
                `;
            });

            // Vérifie si des offres ont été affichées
            if (liste.innerHTML === '') {
                liste.innerHTML = `
                    <div style="text-align:center;padding:40px;color:#94a3b8;">
                        Aucune offre correspondante trouvée. Réessayez avec d'autres compétences.
                    </div>
                `;
            }

            resultats.classList.remove('hidden');

        } else {
            alert(data.message);
        }

    } catch (error) {
        alert('Erreur de connexion. Réessayez.');
    } finally {
        btn.disabled = false;
        btn.classList.remove('opacity-50');
        loading.classList.add('hidden');
    }
}
</script>

@endsection