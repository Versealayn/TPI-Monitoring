
<div class='flex bg-gray-100 items-center justify-center mb-32'>
    <div class='grid bg-white rounded-lg shadow-xl w-11/12 md:w-9/12 lg:w-1/2 mt-20 mb-32'>
        <form class='mt-5 mb-5' method='post' action='index.php?controller=admin&action=addProject'>
            <div class='flex justify-center'>
            <div class='mt-10'>
                <h1 class='text-gray-600 font-bold md:text-2xl text-xl'>Créer un projet</h1>
                <span class='justify-center md:text-2xl text-xl text-teal-700 font-black'></span>
            </div>
            </div>
            <div class='grid grid-cols-1 mt-5 mx-7'>
                <label class='uppercase md:text-sm text-xs text-gray-500 text-light font-semibold'>Nom du projet</label>
                <input class='py-2 px-3 rounded-lg border-2 border-teal-300 mt-1 focus:outline-none focus:ring-2 focus:ring-teal-600 focus:border-transparent' id='proName' name='proName' type='text' placeholder='ICT101 - Web' required/>
            </div>

            <div class='grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-8 mt-5 mx-7'>
                <div class='grid grid-cols-1'>
                    <label class='uppercase md:text-sm text-xs text-gray-500 text-light font-semibold'>Date de début | Format : yyyy-mm-dd</label>
                    <input class='py-2 px-3 rounded-lg border-2 border-teal-300 mt-1 focus:outline-none focus:ring-2 focus:ring-teal-600 focus:border-transparent' id='proStart' name='proStart' type='text' placeholder='1970-01-01' required/>
                </div>
                <div class='grid grid-cols-1'>
                    <label class='uppercase md:text-sm text-xs text-gray-500 text-light font-semibold'>Date de fin | Format : yyyy-mm-dd</label>
                    <input class='py-2 px-3 rounded-lg border-2 border-teal-300 mt-1 focus:outline-none focus:ring-2 focus:ring-teal-600 focus:border-transparent' id='proEnd' name='proEnd' type='text' placeholder='2038-01-19' required/>
                </div>
            </div>
            <div class='grid grid-cols-1 mt-5 mx-7'>
                <label class='uppercase md:text-sm text-xs text-gray-500 text-light font-semibold'>Choisir une classe ou un groupe à ajouter</label>
                <select id='0clagro' name='0clagro' class='py-2 px-3 rounded-lg border-2 border-teal-300 mt-1 focus:outline-none focus:ring-2 focus:ring-teal-600 focus:border-transparent'>
                    <?php
                        foreach ($clagro as $cg){
                            echo '<option value=\''.$cg['idClass'].'\'>'.$cg['claName'].'</option>';
                        }
                    ?>
                </select>
                <input type='text' id='nmbClagro' value='1' name='nmbClagro' style='display:none'>
                <div id='addclagro'></div>
                <div class='flex justify-between'>
                    <h1 onclick='addclagro()' class='text-green-300 font-bold' id='addclagro'>+ Ajouter</h1>
                    <h1 onclick='delclagro()' class='text-red-300 font-bold' id='delclagro'>- Supprimer le dernier</h1>
                </div>
            </div>
            
            <div class='flex items-center justify-center md:gap-8 gap-4 pt-5 pb-5'>
                <button onclick='history.back()' class='bg-red-400 hover:bg-red-300 text-white text-2xl font-bold py-2 px-4 border-b-4 border-red-600 hover:border-red-400 rounded'>
                Annuler
                </button>
                <button type='submit' class='bg-teal-400 hover:bg-teal-300 text-white text-2xl font-bold py-2 px-4 border-b-4 border-teal-600 hover:border-teal-400 rounded'>
                Créer
                </button>
            </div>
        </form>
  </div>
</div>

<script>
    $incr = 1
    $nmbClagro = document.getElementById('nmbClagro');
    function addclagro() {
        console.log('coucou');
        document.getElementById('addclagro').innerHTML += '<select id=\''+$incr+'clagro\' name=\''+$incr+'clagro\' class=\'w-full py-2 px-3 rounded-lg border-2 border-teal-300 mt-1 focus:outline-none focus:ring-2 focus:ring-teal-600 focus:border-transparent\'><?php foreach($classes as $class){echo '<option value=\''.$class['idClagro'].'\'>'.$class['claName'].'</option>';}?> </select>';
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