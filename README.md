TaskFlow ✦
Proiect de Practică — To-Do List
Descriere
TaskFlow este o aplicație web de tip To-Do List, dezvoltată ca proiect de practică.
Aplicația permite utilizatorilor să își gestioneze sarcinile zilnice: adăugare, editare, ștergere și marcare ca finalizate.
Tehnologii folosite

PHP 8.2 — logica serverului
HTML5 / CSS3 — structura și stilizarea
JavaScript — interactivitate
JSON — salvarea datelor (users.json, items.json)
PHP Built-in Server — server local de dezvoltare

Structura proiectului
taskflow/
├── index.php           # Pagina principală
├── login.php           # Autentificare
├── register.php        # Înregistrare cont nou
├── logout.php          # Deconectare
├── dashboard.php       # Lista de sarcini (pagină protejată)
├── contact.php         # Formular de contact
├── css/
│   └── style.css       # Stiluri (dark/light mode, responsive)
├── js/
│   └── script.js       # JavaScript (temă, navigare, validare)
├── php/
│   ├── auth.php        # Funcții autentificare
│   ├── functions.php   # Funcții sarcini
│   └── save_data.php   # Utilitare JSON
└── data/
    ├── users.json      # Utilizatori înregistrați
    └── items.json      # Sarcini salvate
Funcționalități

✅ Pagina principală cu prezentarea aplicației
✅ Înregistrare utilizator
✅ Autentificare și deconectare
✅ Sesiune utilizator
✅ Pagină protejată (dashboard)
✅ Adăugare / editare / ștergere sarcini
✅ Dark mode / Light mode
✅ Multilingv (Română / Engleză / Rusă)
✅ Design responsive (telefon, tabletă, calculator)
✅ Validarea formularelor
✅ Mesaje de succes și eroare
✅ Formular de contact
✅ Salvare date în fișiere JSON

Cum rulezi proiectul

Asigură-te că ai PHP instalat (php -v)
Navighează în folderul proiectului
Rulează comanda:

php -S localhost:8000

Deschide browserul la http://localhost:8000

Autor
Osadcii Nicu — Proiect de practică 2025
