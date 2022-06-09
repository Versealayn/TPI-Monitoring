<div class='flex bg-gray-100 items-center justify-center mb-32'>
    <div class='grid bg-white rounded-lg shadow-xl w-11/12 md:w-9/12 lg:w-1/2 mt-20 mb-32'>
        <form class='mt-5 mb-5' method='post' action='index.php?controller=admin&action=addClass'>
            <?php
            if (isset($errorMsg) && !empty($errorMsg)) {
                echo '
                <div class=\'flex justify-center\'>
                    <div class=\'mt-10\'>
                        <h1 class=\'text-red-600 font-bold md:text-2xl text-xl\'>'.$errorMsg.'</h1>
                        <span class=\'justify-center md:text-2xl text-xl text-teal-700 font-black\'></span>
                    </div>
                </div>
                ';
            };
            ?>
            <div class='flex justify-center'>
                <div class='mt-10'>
                    <h1 class='text-gray-600 font-bold md:text-2xl text-xl'>Créer une classe ou un groupe</h1>
                    <span class='justify-center md:text-2xl text-xl text-teal-700 font-black'></span>
                </div>
            </div>
            <div class='grid grid-cols-1 mt-5 mx-7'>
                <label class='uppercase md:text-sm text-xs text-gray-500 text-light font-semibold'>Nom de la classe ou du groupe</label>
                <input class='py-2 px-3 rounded-lg border-2 border-teal-300 mt-1 focus:outline-none focus:ring-2 focus:ring-teal-600 focus:border-transparent' id='claName' name='claName' type='text' placeholder='CIN3B' required/>
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