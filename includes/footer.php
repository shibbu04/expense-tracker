</div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Initialize tooltips and form validations
        document.addEventListener('DOMContentLoaded', function() {
            // Format currency inputs
            const amountInput = document.getElementById('amount');
            if (amountInput) {
                amountInput.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/[^\d.]/g, '');
                    if (value.split('.').length > 2) {
                        value = value.replace(/\.+$/, '');
                    }
                    e.target.value = value;
                });
            }
            
            // Auto-refresh expenses when filters change
            const monthSelect = document.getElementById('month');
            const yearSelect = document.getElementById('year');
            
            if (monthSelect && yearSelect) {
                monthSelect.addEventListener('change', loadExpenses);
                yearSelect.addEventListener('change', loadExpenses);
            }
            
            // Load expenses on page load
            loadExpenses();
        });
        
        function loadExpenses() {
            const month = document.getElementById('month')?.value || '';
            const year = document.getElementById('year')?.value || '';
            
            fetch(`get_expenses.php?month=${month}&year=${year}`)
                .then(response => response.json())
                .then(data => {
                    updateExpensesTable(data.expenses);
                    updateTotalAmount(data.total);
                })
                .catch(error => console.error('Error:', error));
        }
        
        function updateExpensesTable(expenses) {
            const tbody = document.getElementById('expenses-tbody');
            if (!tbody) return;
            
            tbody.innerHTML = '';
            
            if (expenses.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-slate-500">
                            <div class="text-6xl mb-4">📊</div>
                            <p class="text-lg">No expenses found</p>
                            <p class="text-sm">Add your first expense to get started!</p>
                        </td>
                    </tr>
                `;
                return;
            }
            
            expenses.forEach(expense => {
                const row = document.createElement('tr');
                row.className = 'hover:bg-slate-50 transition-colors border-b border-slate-200';
                row.innerHTML = `
                    <td class="px-6 py-4 text-slate-700">${formatDate(expense.date)}</td>
                    <td class="px-6 py-4 font-semibold text-slate-800">₹${parseFloat(expense.amount).toFixed(2)}</td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 rounded-full text-xs font-medium ${getCategoryColor(expense.category)}">
                            ${expense.category}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-slate-600">${expense.description || '-'}</td>
                    <td class="px-6 py-4 text-slate-500 text-sm">${formatDate(expense.created_at)}</td>
                `;
                tbody.appendChild(row);
            });
        }
        
        function updateTotalAmount(total) {
            const totalElement = document.getElementById('total-amount');
            if (totalElement) {
                totalElement.textContent = `₹${parseFloat(total).toFixed(2)}`;
            }
        }
        
        function formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('en-IN', {
                year: 'numeric',
                month: 'short',
                day: 'numeric'
            });
        }
        
        function getCategoryColor(category) {
            const colors = {
                'Food': 'bg-amber-100 text-amber-800',
                'Transportation': 'bg-blue-100 text-blue-800',
                'Shopping': 'bg-rose-100 text-rose-800',
                'Entertainment': 'bg-purple-100 text-purple-800',
                'Bills': 'bg-red-100 text-red-800',
                'Healthcare': 'bg-green-100 text-green-800',
                'Education': 'bg-indigo-100 text-indigo-800',
                'Other': 'bg-gray-100 text-gray-800'
            };
            return colors[category] || 'bg-slate-100 text-slate-800';
        }
        
        // Show success message
        function showSuccess(message) {
            const successDiv = document.createElement('div');
            successDiv.className = 'fixed top-4 right-4 bg-emerald-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 transform transition-all duration-300 translate-x-full';
            successDiv.innerHTML = `
                <div class="flex items-center gap-2">
                    <span class="text-lg">✅</span>
                    <span>${message}</span>
                </div>
            `;
            document.body.appendChild(successDiv);
            
            setTimeout(() => successDiv.classList.remove('translate-x-full'), 100);
            setTimeout(() => {
                successDiv.classList.add('translate-x-full');
                setTimeout(() => successDiv.remove(), 300);
            }, 3000);
        }
    </script>
</body>
</html>