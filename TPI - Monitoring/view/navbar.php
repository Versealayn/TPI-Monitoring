<?php
/**
 * ETML
 * Auteur : Nelson Tivollier
 * Date: 11.05.2022
 * Projet : TPI - Monitoring
 * Page Name : ProjectRepository.php
 * Description : Connexion à la base de données
 */

echo'
    <div>
        <div class=\'px-10 py-4\'>
            <div class=\'container mx-auto flex items-center justify-between\'>
                <a href=\'index.php\'>
                    <h1 class=\'text-4xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-green-500 to-teal-400\'>TPIM</h1>
                </a>
                    '; 
                    if (!(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)) {
                        echo'<a href=\'index.php?controller=login&action=index\'>
                        <button class=\'bg-teal-400 hover:bg-teal-300 text-white text-2xl font-bold py-2 px-4 border-b-4 border-teal-600 hover:border-teal-400 rounded\'>
                        Login
                        </button>';
                    }
                    else{
                        echo'<a href=\'index.php?controller=login&action=logout\'>
                        <button class=\'bg-teal-400 hover:bg-teal-300 text-white text-2xl font-bold py-2 px-4 border-b-4 border-teal-600 hover:border-teal-400 rounded\'>
                        Logout
                        </button>';
                    }
                    echo'
                </a>
            </div>
        </div>
    </div>
';
?>
