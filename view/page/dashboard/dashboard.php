<?php
if (!(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)) {
    header('location: index.php?controller=login&action=index');
};
if ($_SESSION['user']['userRight'] == 'teacher'){
    echo '<div class=\'w-4/5 mx-auto\'>
    <a href=\'index.php?controller=admin&action=displayAddProject\'>
            <button class=\'w-100 bg-green-400 hover:bg-green-500 text-white text-xl font-bold py-2 px-4 border-b-4 border-green-600 hover:border-green-700 rounded mt-4\'>
            + Créer un projet
            </button>
        </a>
        <a href=\'index.php?controller=admin&action=displayAddClass\'>
            <button class=\'w-100 bg-green-400 hover:bg-green-500 text-white text-xl font-bold py-2 px-4 border-b-4 border-green-600 hover:border-green-700 rounded mt-4\'>
            + Créer une classe
            </button>
        </a>
        <a href=\'index.php?controller=admin&action=displayLinkStudent\'>
            <button class=\'w-100 bg-green-400 hover:bg-green-500 text-white text-xl font-bold py-2 px-4 border-b-4 border-green-600 hover:border-green-700 rounded mt-4\'>
            + Lier un élève
            </button>
        </a>
        </div>
    ';
}
echo'
<div class=\'w-4/5 mx-auto\'>
    <div class=\'grid mt-0 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 pt-3 gap-8\'>
            ';
            foreach ($projectsClagro as $proclagro){
                echo'
                <div class=\'rounded bg-gray-100 h-45 p-5 pl-6\'>
                    <div class=\'rounded flex justify-center shadow-inner w-24 h-8 bg-gray-200\'>
                        <h1 class=\'text-gray-500 font-black mt-1 \'>'.$proclagro['claName'].'</h1>
                    </div>
                    <h1 class=\'mt-3 text-gray-800 text-xl\'>'.$proclagro['proName'].'<h1>
                    <p class=\'text-gray-600\'>
                        '.$proclagro['proStart'].' | '.$proclagro['proEnd'].'
                    </p>
                    <a href=\'index.php?controller=dashboard&action=project&id='.$proclagro['idProject'].'\'>
                        <button class=\'w-28  bg-teal-400 hover:bg-teal-500 text-white text-xl font-bold py-2 px-4 border-b-4 border-teal-600 hover:border-teal-700 rounded mt-4\'>
                        Accéder
                        </button>
                    </a>';
                    if ($_SESSION['user']['userRight'] == 'teacher'){
                    echo'
                    <a href=\'index.php?controller=admin&action=displayModifyProject&id='.$proclagro['idProject'].'\'>
                        <button class=\'w-28 bg-gray-400 hover:bg-gray-500 text-white text-xl font-bold py-2 px-4 border-b-4 border-gray-500 hover:border-gray-600 rounded mt-4\'>
                        Modifier
                        </button>
                    </a>';
                    }
                    echo'
                </div>';
            }
            echo'
		</div>
    </div>
</div>';
?>
