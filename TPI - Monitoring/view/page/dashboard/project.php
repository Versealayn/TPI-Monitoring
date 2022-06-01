<?php
if (!(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)) {
    header('location: index.php?controller=login&action=index');
};

foreach ($project as $task){
    echo '
    <div class="lg:flex w-4/5 mx-auto rounded-lg border border-gray-400">
    <div class="w-full lg:w-11/12 xl:w-full px-1 bg-white py-5 lg:px-2 lg:py-2 tracking-wide">     
        <div class="font-semibold text-gray-800 text-xl text-center lg:text-left px-2">
            '.$task['tasName'].'
        </div>

        <div class="text-gray-600 font-medium text-sm pt-1 text-center lg:text-left px-2">
        '.$task['tasStart'].' - '.$task['tasEnd'].'
        </div>
    </div>
    <div class="flex flex-row items-center w-full lg:w-1/3 bg-white lg:justify-end justify-center px-2 py-4 lg:px-0">
        <span id="'.$task['idTask'].'" class="tracking-wider text-gray-600 bg-gray-200 px-2 text-sm rounded leading-loose mx-2 font-semibold" onclick="changeState('.$task['idTask'].')"
        >'.$task['tasState'].'</span>
    </div>
</div>
    ';
}
?>

<script>
    function changeState($idTask){
        $span = document.getElementById($idTask);
        switch($span.innerHTML){
            case 'Pas démarré':
                changeMySqlState($idTask, 'En cours');
            break;
            case 'En cours':
                changeMySqlState($idTask, 'Terminé');
            break;
            case 'Terminé':
                changeMySqlState($idTask, 'Pas démarré');
            break;
        }
    }

    function changeMySqlState($idTask, $state) {
        window.location = 'index.php?controller=dashboard&action=state&state=' + $state + '&id=' + $idTask;
    }
</script>