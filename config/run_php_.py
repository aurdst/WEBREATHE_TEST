import schedule
import time
import subprocess
import os

# Fichier de verrouillage pour éviter d'exécuter un job en même temps
lock_file = "job.lock"

def job():
    # Vérifie si le job est déjà en cours
    if os.path.exists(lock_file):
        return

    # Crée un fichier de verrouillage pour éviter une exécution simultanée
    with open(lock_file, "w") as f:
        f.write("")

    try:
        result = subprocess.Popen(
            ['php', 'C:\\Users\\Brocolis\\Desktop\\PROJET\\WEBREATHE_TEST\\config\\generate_data\\insert_module_data.php']
        )
        
        print(result.stdout)  # Afficher la sortie du script
        print(result.stderr)  # Afficher les erreurs si présentes

    finally:
        # Supprime le fichier de verrouillage une fois le job terminé
        os.remove(lock_file)

# Planifie le job pour qu'il s'exécute toutes les minutes
schedule.every(1).seconds.do(job)

while True:
    schedule.run_pending()
    time.sleep(1)
