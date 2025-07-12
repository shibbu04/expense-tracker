<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense Tracker</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="assets/style.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'slate-950': '#0a0a0a',
                        'emerald-950': '#064e3b',
                        'rose-950': '#4c0519',
                        'amber-950': '#451a03',
                        'indigo-950': '#1e1b4b',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gradient-to-br from-slate-50 to-stone-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <header class="flex justify-between items-center mb-8">
            <div class="w-24"></div>
            <div class="text-center">
                <h1 class="text-4xl font-bold text-slate-800 mb-2">💰 Expense Tracker</h1>
                <p class="text-slate-600">Track your expenses with style</p>
            </div>
            <div class="w-24 text-right">
                <a href="Debug/debug.php" class="inline-block px-4 py-2 bg-green-600 text-white rounded hover:bg-indigo-700 transition">Debug</a>
            </div>
        </header>