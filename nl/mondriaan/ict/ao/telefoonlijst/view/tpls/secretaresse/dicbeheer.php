<?php include 'includes/header.php';
include 'includes/menu.php';?>
    <section id='content'>
        <table id="contacten">
            <caption>dit zijn alle directeuren van de school voor ict</caption>
            <thead>
                <tr><td>foto</td><td>naam</td><td>email</td><td>intern</td><td>extern</td><td colspan="3">acties</td></tr>
            </thead>
            <?php foreach($directeuren as $directeur):?>
                <tr>
                    <td><figure><img src="img/personen/<?= $directeur->getFoto();?>" alt="de foto van <?= $directeur->getNaam();?>"></figure></td>
                    <td><?= $directeur->getNaam();?></td>
                    <td><?= $directeur->getEmail();?></td>
                    <td><?= $directeur->getIntern();?></td>
                    <td><?= $directeur->getExtern();?></td>
                  
                    <td title="reset het wachtwoord van dit contact naar qwerty"><a href='?control=secretaresse&action=resetww&id=<?= $directeur->getId();?>'><img src="img/resetww.png"></a></td>
                    <td title="bewerk de contact gegevens van dit contact"><a href='?control=secretaresse&action=wijziggebruikers&id=<?= $directeur->getId();?>'><img src="img/bewerk.png"></a></td>
                    <td title="verwijder dit contact definitief"><a href='?control=secretaresse&action=delete&id=<?= $directeur->getId();?>'><img src="img/verwijder.png"></a></td>
                </tr>
            <?php endforeach;?>
                <tr><td><a href='?control=secretaresse&action=add'><figure><img src="img/toevoegen.png" alt='voeg een contact toe image' title='voeg een contact toe'></figure></a></td><td colspan='8'>voeg een contact aan de school toe</td></tr>
        </table>
        <br id ="breaker">
    </section>

<?php include 'includes/footer.php';