# TaskFlow — Proiect de Practică

## Descriere
Aplicație web de tip To-Do List dezvoltată ca proiect de practică.

## Structura proiectului
```
todo-project/
├── index.php           # Pagina principală
├── login.php           # Autentificare
├── register.php        # Înregistrare
├── logout.php          # Deconectare
├── dashboard.php       # Pagina protejată (lista de sarcini)
├── contact.php         # Formular contact
├── css/
│   └── style.css       # Stiluri (dark/light mode, responsive)
├── js/
│   └── script.js       # JavaScript (tema, navigare, validare)
├── php/
│   ├── auth.php        # Funcții autentificare
│   ├── functions.php   # Funcții sarcini și feedback
│   ├── save_data.php   # Utilitare JSON
│   └── navbar_partial.php  # Navbar reutilizabil
└── data/
    ├── users.json      # Utilizatori înregistrați
    ├── items.json      # Sarcini (tasks)
    └── feedback.json   # Mesaje contact
```

## Cerințe server
- PHP 7.4+
- Server local: XAMPP / WAMP / Laragon

## Instalare
1. Copiază folderul în `htdocs/` (XAMPP)
2. Accesează `http://localhost/todo-project/`

## Funcționalități implementate
- [x] Pagina principală cu prezentare
- [x] Înregistrare utilizator (salvat în users.json)
- [x] Autentificare
- [x] Deconectare
- [x] Sesiune utilizator
- [x] Pagină protejată (dashboard)
- [x] Dark mode / Light mode
- [x] Schimbarea limbii (RO/EN/RU)
- [x] Meniu de navigare responsive
- [x] Adăugare/ștergere/editare sarcini
- [x] Salvare în JSON
- [x] Formular contact
- [x] Design responsive
- [x] Validarea formularelor
- [x] Mesaje succes/eroare
- [x] Organizare fișiere

## Ziua 1
- Alegerea temei (To-Do List)
- Instalarea serverului local
- Crearea structurii complete a proiectului
- Publicare pe GitHub
