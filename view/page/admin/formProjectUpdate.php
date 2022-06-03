
<div class='flex bg-gray-100 items-center justify-center mb-32'>
    <div class='grid bg-white rounded-lg shadow-xl w-11/12 md:w-9/12 lg:w-1/2 mt-20 mb-32'>
        <form class='mt-5 mb-5' method='post' action='index.php?controller=admin&action=update&id=<?php echo $project[0]['idProject'];?>'>
            <div class='flex justify-center'>
                <div class='mt-10'>
                    <h1 class='text-gray-600 font-bold md:text-2xl text-xl'>Vous modifiez le projet</h1>
                    <span class='justify-center md:text-2xl text-xl text-teal-700 font-black'><?php echo $project[0]['proName'];?></span>
                </div>
            </div>
            <div class='grid grid-cols-1 mt-5 mx-7'>
                <label class='uppercase md:text-sm text-xs text-gray-500 text-light font-semibold'>Nom du projet</label>
                <input class='py-2 px-3 rounded-lg border-2 border-teal-300 mt-1 focus:outline-none focus:ring-2 focus:ring-teal-600 focus:border-transparent' id='proName' name='proName' type='text' value='<?php echo $project[0]['proName'];?>' required/>
            </div>

            <div class='mb-5 grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-8 mt-5 mx-7'>
                <div class='grid grid-cols-1'>
                    <label class='uppercase md:text-sm text-xs text-gray-500 text-light font-semibold'>Date de début | Format : yyyy-mm-dd</label>
                    <input class='py-2 px-3 rounded-lg border-2 border-teal-300 mt-1 focus:outline-none focus:ring-2 focus:ring-teal-600 focus:border-transparent' id='proStart' name='proStart' type='text' value='<?php echo $project[0]['proStart'];?>' required/>
                </div>
                <div class='grid grid-cols-1'>
                    <label class='uppercase md:text-sm text-xs text-gray-500 text-light font-semibold'>Date de fin | Format : yyyy-mm-dd</label>
                    <input class='py-2 px-3 rounded-lg border-2 border-teal-300 mt-1 focus:outline-none focus:ring-2 focus:ring-teal-600 focus:border-transparent' id='proEnd' name='proEnd' type='text' value='<?php echo $project[0]['proEnd'];?>'required />
                </div>
            </div>
            <label class='mx-7 uppercase md:text-sm text-xs text-gray-500 text-light font-semibold'>Liste des classes et groupes associés</label>

            <?php
            echo'<div class=\'mx-7 w-5/6 container mx-auto grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-10 pt-4 gap-8\'>';
            foreach($clagro as $cg)
            {
                echo'
                <div class=\'rounded flex justify-center bg-gray-100 h-7\'>
                '.$cg['claName'].'
                </div>
                ';
            }
            echo'</div>';
            ?>

            <div class='flex items-center justify-center md:gap-8 gap-4 pt-5 pb-5'>
                <a onclick='history.back()' class='bg-red-400 hover:bg-red-300 text-white text-2xl font-bold py-2 px-4 border-b-4 border-red-600 hover:border-red-400 rounded'>
                    Annuler
                </a>
                <button type='submit' class='bg-teal-400 hover:bg-teal-300 text-white text-2xl font-bold py-2 px-4 border-b-4 border-teal-600 hover:border-teal-400 rounded'>
                Modifier
                </button>
            </div>
        </form>
  </div>
</div>
<script>
    $incr = 1
    $nmbClagro = document.getElementById('nmbClagro');
    function addclagro() {
        document.getElementById('addclagro').innerHTML += '<select id=\''+$incr+'clagro\' name=\''+$incr+'clagro\' class=\'w-full py-2 px-3 rounded-lg border-2 border-teal-300 mt-1 focus:outline-none focus:ring-2 focus:ring-teal-600 focus:border-transparent\'><?php foreach($classes as $class){echo '<option value=\''.$class['idClass'].'cla\'>'.$class['claName'].'</option>';}foreach($groups as $group){echo '<option value=\''.$group['idGroup'].'gro\'>'.$group['groName'].'</option>';}?> </select>';
        ++$incr;

        $nmbClagro.value = $incr;
    }

    function delclagro() {
        $divname = $incr-1 + 'clagro';
        var elem = document.getElementById($divname);
        elem.remove();
        --$incr;
        $nmbClagro.value = $incr;
    }
</script>