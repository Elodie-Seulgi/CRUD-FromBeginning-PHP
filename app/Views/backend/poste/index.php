<section class="container mt-4">
    <h1 class="text-center">Administration des postes</h1>
    <a href="/admin/postes/create" class="btn btn-primary">Créer un poste</a>
    <div class="mt-2 row gy-3 align-items-stretch">
        <?php foreach ($postes as $poste): ?>
            <div class="col-md-4">
                <!-- md ici fait que c'est responsive avec lg md >> regarder sur le site de Bootstrap breakpoints-->
                <div class="card h-100">
                    <div class="card-header">
                        <h2 class="card-title"><?= $poste->getTitle() ?></h2>
                    </div>
                    <div class="card-body">
                        <em class="card-subtitle text-muted">Créé le
                            <?= $poste->getCreatedAt()->format('d/m/Y') ?></em>
                        <p class="card-text"><?= $poste->getDescription() ?></p>
                        <div class="d-flex justify-content-between mt-3">
                            <a href="/admin/postes/<?= $poste->getId() ?>/edit" class="btn btn-warning">Modifier</a>
                            <form action="/admin/postes/<?= $poste->getId() ?>/delete" method="POST"
                                onsubmit="return confirm('Voulez-vous vraiment supprimer ce poste ?')">
                                <input type="hidden" name="csrf_token" value="<?= $token ?>" />
                                <!-- pour éviter la faille csrf -->
                                <button type="submit" class="btn btn-danger">Supprimer</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    </div>
</section>