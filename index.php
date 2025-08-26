<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
      tailwind.config = {
        theme: {
          extend: {
            colors: {
              blueSky: '#4cb4f531',
              granite: '#b7b8b6ce',
              pine: '#34675ce0',
              fields: '#c6d403cc',
            }
          }
        }
      }
    </script>
    <script src="https://kit.fontawesome.com/b8e5063394.js" crossorigin="anonymous"></script>
</head>
<body>
    <section class="min-h-screen flex justify-center items-center bg-blueSky">
        <div class="w-full max-w-md md:max-w-lg px-4">
            <form id="form1" method="POST" class="bg-granite/60 p-10 rounded-2xl shadow-xl border-t-8 border-fields">
                <div class="flex flex-col items-center mb-8">
                    <span class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-fields shadow-lg mb-2">
                        <i class="fa-solid fa-user-lock text-white text-3xl"></i>
                    </span>
                    <h5 class="text-2xl font-bold text-pine tracking-wide">Iniciar Sesión</h5>
                </div>
                <div class="mb-6">
                    <label for="servidor" class="block text-sm font-medium text-pine mb-1">Servidor</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <i class="fa-solid fa-server text-fields"></i>
                        </span>
                        <input
                            type="text"
                            name="servidor"
                            id="servidor"
                            placeholder="Ingresa servidor"
                            class="w-full pl-10 pr-4 py-2 border border-pine/40 rounded-lg focus:ring-2 focus:ring-fields focus:border-fields text-sm bg-white/80 placeholder-pine/60 transition"
                        >
                    </div>
                </div>
                <div class="mb-6">
                    <label for="email" class="block text-sm font-medium text-pine mb-1">Correo</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <i class="fa-solid fa-envelope text-fields"></i>
                        </span>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            placeholder="Ingresa correo"
                            class="w-full pl-10 pr-4 py-2 border border-pine/40 rounded-lg focus:ring-2 focus:ring-fields focus:border-fields text-sm bg-white/80 placeholder-pine/60 transition"
                        >
                    </div>
                </div>
                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium text-pine mb-1">Contraseña</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <i class="fa-solid fa-lock text-fields"></i>
                        </span>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            placeholder="Ingresa contraseña"
                            class="w-full pl-10 pr-4 py-2 border border-pine/40 rounded-lg focus:ring-2 focus:ring-fields focus:border-fields text-sm bg-white/80 placeholder-pine/60 transition"
                        >
                    </div>
                </div>
                <button type="submit" class="w-full py-2 bg-fields hover:bg-blueSky text-white font-semibold rounded-lg shadow-md transition-all duration-200 text-base">
                    Ingresar
                </button>
            </form>
        </div>
    </section>
    <script>

        function handleFetchErrors(response) {
            if (!response.ok) {
                throw Error(response.statusText);
            }
            return response.json();
        }

        function iniciarSesion(e) {
            e.preventDefault();

            const servidor = document.getElementById("servidor").value;
            const email = document.getElementById("email").value;
            const password = document.getElementById("password").value;

            if (!servidor || !email || !password) {
                return;
            }

            console.log(servidor, email, password);

            const sesionData = {
                servidor,
                email,
                password
            };

            fetch("loginController.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(sesionData)
            })
            .then(handleFetchErrors)
            .then(data => {
                console.log(data);
                if (data.success) {
                    window.location.href = "dashboard.php";
                }else if (data.error){
                    console.error("Usuario o contraseña incorrectos.");
                }

                
            })
            .catch(err => {
                console.error(err);
            });

        }

        document.addEventListener("DOMContentLoaded", function() {
            const form = document.getElementById("form1");
            
            form.addEventListener("submit", iniciarSesion);
        });

    </script>
</body>
</html>