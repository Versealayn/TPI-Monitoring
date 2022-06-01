<?php
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    header('Location: index.php?controller=dashboard&action=list');
};

echo'
<div class=\'grid place-items-center mx-2 my-20 sm:my-auto\'>
    <div class=\'flex\'>
        <span class=\'text-center font-bold my-20 mx-auto\'>
            <a href=\'index.php\'>
              <h1 class=\'text-4xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-green-500 to-teal-400\'>TPIM</h1><h1 class=\'text-white bold\'>LOGIN</h1>
            </a>
            </span>
        </div>
        <div class=\'w-11/12 p-12 sm:w-8/12 md:w-6/12 lg:w-5/12 2xl:w-4/12
                  px-6 py-10 sm:px-10 sm:py-6
                  bg-gray-100 rounded-lg shadow-md lg:shadow-lg\'>

            <!-- Champ pour insérer l\'e-mail -->
            <form class=\'mt-5\' method=\'POST\' action=\'index.php?controller=login&action=login\'>
                <label for=\'email\' class=\'block text-xs font-semibold text-gray-500 uppercase\'>E-mail</label>
                <input id=\'email\' type=\'text\' name=\'email\' placeholder=\'xxxx.xxxx@eduvaud.ch\' autocomplete=\'email\' required
                        class=\'block w-full py-3 px-1 mt-2
                        text-gray-600 bg-gray-200
                        border-b-2 border-teal-400
                        focus:text-gray-500 focus:outline-none focus:border-gray-200\'
                        required />

                <!-- Champ pour insérer le mot de passe -->
                <label for=\'password\' class=\'block mt-2 text-xs font-semibold text-gray-500 uppercase\'>Password</label>
                <input id=\'password\' type=\'password\' name=\'password\' placeholder=\'******\' autocomplete=\'current-password\' required
                        class=\'block w-full py-3 px-1 mt-2 mb-4
                        text-gray-600 bg-gray-200
                        border-b-2 border-b-2 border-teal-400
                        focus:text-gray-500 focus:outline-none focus:border-gray-200\'
                        required />
                        
                <!-- Bouton d\'authentification -->
                <button type=\'submit\'
                        class=\'w-full py-3 mt-10 bg-teal-500 rounded-lg
                        font-medium text-white uppercase
                        focus:outline-none border-b-4 border-teal-600 hover:bg-teal-600 hover:border-teal-700 hover:shadow-none\'>
                        Login
                </button>
            </form>
        </div>
    </div>
</div>';
?>