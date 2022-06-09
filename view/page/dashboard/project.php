<?php
if (!(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)) {
    header('location: index.php?controller=login&action=index');
}

if ($_SESSION['user']['userRight'] == 'teacher'){
    echo '  <div class=\'w-4/5 mx-auto mb-5\'>
                <a href=\'index.php?controller=admin&action=displayAddTask&id='.$_GET['id'].'\'>
                    <button class=\'w-100  bg-green-400 hover:bg-green-500 text-white text-xl font-bold py-2 px-4 border-b-4 border-green-600 hover:border-green-700 rounded mt-4\'>
                    + Créer une tâche
                    </button>
                </a>
                <a href=\'index.php?controller=admin&action=visualize&id='.$_GET['id'].'\'>
                    <button class=\'w-100  bg-teal-400 hover:bg-teal-500 text-white text-xl font-bold py-2 px-4 border-b-4 border-teal-600 hover:border-teal-700 rounded mt-4\'>
                    Superviser
                    </button>
                </a>
            </div>
    ';
}

if ($project == NULL){
    echo'
    <div class=\'mt-24 mx-auto w-5/6\'>
        <div class=\'container flex flex-col md:flex-row items-center justify-between px-5 text-gray-700\'>
            <div class=\'w-full lg:w-1/2 mx-8\'>
                <div class=\'text-7xl text-green-500 font-dark font-extrabold mb-8\'>Oopsi !</div>
            <p class=\'text-2xl md:text-3xl font-light leading-normal mb-8\'>
                Ce projet ne comporte pas de tâche
            </p>
            
            <a href=\'index.php\' class=\'px-5 inline py-3 text-sm font-medium leading-5 shadow-2xl text-white transition-all duration-400 border border-transparent rounded-lg  bg-green-600 hover:bg-green-700\'>Retour à la dashboard</a>
        </div>
    </div>

    ';
}
else{
    foreach ($project as $task){
        
        echo '
        <div class=\'lg:flex w-4/5 mx-auto rounded-lg bg-gray-200 mb-5\'>
            <div class=\'task-name w-full lg:w-11/12 xl:w-full px-1  py-5 lg:px-2 lg:py-2 tracking-wide\'>
                <div class=\'font-semibold text-gray-800 text-xl text-center lg:text-left px-2\'>
                    '.$task['tasName'].'
                </div>

                <div class=\'hidden-description font-semibold\'>
                    <p>'.$task['tasDescription'].'</p>
                </div>

                <div class=\'text-gray-600 font-medium text-sm pt-1 text-center lg:text-left px-2\'>
                '.$task['tasStart'].' - '.$task['tasEnd'].'
                </div>
            </div>';
            if ($_SESSION['user']['userRight'] == 'teacher'){
                echo' <div class=\'flex flex-row items-center w-full flex-1 justify-center mb-3 mr-4 ml-4 lg:px-0\'>
                    <a href=\'index.php?controller=admin&action=displayEditTask&id='.$task['idTask'].'\' class=\'mr-1 w-28 bg-gray-400 hover:bg-gray-500 text-white text-xl font-bold py-2 px-4 border-b-4 border-gray-500 hover:border-gray-600 rounded mt-4\'>
                        Modifier
                    </a>
                    <button onclick=alert(\'nonㅤimplémentéㅤ(nonㅤdemandéㅤparㅤleㅤcahierㅤdesㅤcharges)\') class=\'w-100  bg-red-400 hover:bg-red-500 text-white text-xl font-bold py-2 px-4 border-b-4 border-red-600 hover:border-red-700 rounded mt-4\'>
                        Supprimer
                    </button>
            </div>';
            }
            else{
                echo'<div class=\'flex flex-row items-center w-full lg:w-1/3 lg:justify-end justify-center px-2 py-4 lg:px-0\'>
                <span id=\''.$task['idTask'].'\' class=\'tracking-wider text-gray-600 bg-gray-400 px-2 text-sm rounded leading-loose mx-2 font-semibold\' onclick=\'changeState('.$task['idTask'].','.$_SESSION['user']['userId'].')\'>'; 
                
                if ($task['idTask'] == $task['fkTask'] and $task['fkUser'] == $_SESSION['user']['userId']){
                    echo $task['staState'];
                }
                else {
                    echo'Pas démarré';
                }
            }
             echo'</span>
        </div>
        </div>
        ';
    }
}
?>

<script>
    function showModal(idTask){
      
    }

    function changeState(idTask, idUser){
        span = document.getElementById(idTask);
        switch(span.innerHTML){
            case 'Pas démarré':
                changeMySqlState(idUser, idTask, 'En cours');
            break;
            case 'En cours':
                changeMySqlState(idUser, idTask, 'Terminé');
            break;
            case 'Terminé':
                changeMySqlState(idUser, idTask, 'Pas démarré');
            break;
        }
    }

    function changeMySqlState(idUser, idTask, state) {
        window.location = 'index.php?controller=dashboard&action=state&iduser=' + idUser + '&state=' + state + '&id=' + idTask;
    }
</script>