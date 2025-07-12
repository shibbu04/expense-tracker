<?php
require_once 'config/database.php';
require_once 'includes/header.php';

// Get current month and year for default filters
$currentMonth = date('m');
$currentYear = date('Y');
?>

<div class="max-w-6xl mx-auto">
    <!-- Add Expense Form -->
    <div class="bg-white rounded-2xl shadow-lg p-6 mb-8 border border-slate-200">
        <h2 class="text-2xl font-bold text-slate-800 mb-6 flex items-center gap-2">
            <span class="text-2xl">➕</span>
            Add New Expense
        </h2>

        <form id="expense-form" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="space-y-2">
                <label for="date" class="block text-sm font-medium text-slate-700">Date</label>
                <input type="date" id="date" name="date" required
                    class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-slate-400 focus:border-transparent transition-all"
                    value="<?php echo date('Y-m-d'); ?>">
            </div>

            <div class="space-y-2">
                <label for="amount" class="block text-sm font-medium text-slate-700">Amount (₹)</label>
                <input type="number" id="amount" name="amount" step="0.01" min="0" required
                    class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-slate-400 focus:border-transparent transition-all"
                    placeholder="0.00">
            </div>

            <div class="space-y-2">
                <label for="category" class="block text-sm font-medium text-slate-700">Category</label>
                <select id="category" name="category" required
                    class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-slate-400 focus:border-transparent transition-all">
                    <option value="">Select Category</option>
                    <option value="Food">🍔 Food</option>
                    <option value="Transportation">🚗 Transportation</option>
                    <option value="Shopping">🛍️ Shopping</option>
                    <option value="Entertainment">🎬 Entertainment</option>
                    <option value="Bills">📄 Bills</option>
                    <option value="Healthcare">🏥 Healthcare</option>
                    <option value="Education">📚 Education</option>
                    <option value="Other">📦 Other</option>
                </select>
            </div>

            <div class="space-y-2">
                <label for="description" class="block text-sm font-medium text-slate-700">Description</label>
                <input type="text" id="description" name="description"
                    class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-slate-400 focus:border-transparent transition-all"
                    placeholder="Optional description">
            </div>

            <div class="md:col-span-2 lg:col-span-4">
                <button type="submit"
                    class="w-full md:w-auto px-8 py-3 bg-gradient-to-r from-slate-600 to-slate-700 hover:from-slate-700 hover:to-slate-800 text-white font-medium rounded-xl transition-all transform hover:scale-105 shadow-lg">
                    Add Expense
                </button>
            </div>
        </form>
    </div>

    <!-- Filters and Summary -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-lg p-6 border border-slate-200">
            <h3 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-2">
                <span class="text-xl">🔍</span>
                Filter Expenses
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-2">
                    <label for="month" class="block text-sm font-medium text-slate-700">Month</label>
                    <select id="month" name="month"
                        class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-slate-400 focus:border-transparent transition-all">
                        <option value="">All Months</option>
                        <option value="01" <?php echo ($currentMonth == '01') ? 'selected' : ''; ?>>January</option>
                        <option value="02" <?php echo ($currentMonth == '02') ? 'selected' : ''; ?>>February</option>
                        <option value="03" <?php echo ($currentMonth == '03') ? 'selected' : ''; ?>>March</option>
                        <option value="04" <?php echo ($currentMonth == '04') ? 'selected' : ''; ?>>April</option>
                        <option value="05" <?php echo ($currentMonth == '05') ? 'selected' : ''; ?>>May</option>
                        <option value="06" <?php echo ($currentMonth == '06') ? 'selected' : ''; ?>>June</option>
                        <option value="07" <?php echo ($currentMonth == '07') ? 'selected' : ''; ?>>July</option>
                        <option value="08" <?php echo ($currentMonth == '08') ? 'selected' : ''; ?>>August</option>
                        <option value="09" <?php echo ($currentMonth == '09') ? 'selected' : ''; ?>>September</option>
                        <option value="10" <?php echo ($currentMonth == '10') ? 'selected' : ''; ?>>October</option>
                        <option value="11" <?php echo ($currentMonth == '11') ? 'selected' : ''; ?>>November</option>
                        <option value="12" <?php echo ($currentMonth == '12') ? 'selected' : ''; ?>>December</option>
                    </select>
                </div>

                <div class="space-y-2">
                    <label for="year" class="block text-sm font-medium text-slate-700">Year</label>
                    <select id="year" name="year"
                        class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-slate-400 focus:border-transparent transition-all">
                        <option value="">All Years</option>
                        <?php
                        for ($year = date('Y'); $year >= 2020; $year--) {
                            $selected = ($year == $currentYear) ? 'selected' : '';
                            echo "<option value='$year' $selected>$year</option>";
                        }
                        ?>
                    </select>
                    <div class="mt-4 text-right">
                        <button onclick="clearFilters()" class="px-4 py-2 text-sm text-white bg-red-500 rounded-lg hover:bg-red-600">Clear Filters</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-slate-600 to-slate-700 rounded-2xl shadow-lg p-6 text-white">
            <h3 class="text-xl font-bold mb-4 flex items-center gap-2">
                <span class="text-xl">💰</span>
                Total Expenses
            </h3>
            <div class="text-3xl font-bold" id="total-amount">₹0.00</div>
            <p class="text-slate-200 mt-2">For selected period</p>
        </div>
    </div>

    <!-- Expenses Table -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-slate-200">
        <div class="px-6 py-4 border-b border-slate-200">
            <h3 class="text-xl font-bold text-slate-800 flex items-center gap-2">
                <span class="text-xl">📊</span>
                Expense History
            </h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Description</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Added</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody id="expenses-tbody">
                    <!-- Expenses will be loaded here via JavaScript -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.getElementById('expense-form').addEventListener('submit', function(e) {
        e.preventDefault();

        // Get form elements
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.textContent;

        // Validate form before submission
        const date = document.getElementById('date').value;
        const amount = document.getElementById('amount').value;
        const category = document.getElementById('category').value;

        if (!date || !amount || !category) {
            alert('Please fill in all required fields');
            return;
        }

        if (isNaN(amount) || parseFloat(amount) <= 0) {
            alert('Please enter a valid amount');
            return;
        }

        // Show loading state
        submitBtn.textContent = 'Adding...';
        submitBtn.disabled = true;

        const formData = new FormData(this);

        fetch('add_expense.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Response:', data); // Debug log

                if (data.success) {
                    showSuccess('Expense added successfully!');
                    this.reset();
                    document.getElementById('date').value = new Date().toISOString().split('T')[0];
                    loadExpenses();
                } else {
                    console.error('Error details:', data);
                    alert('Error: ' + (data.message || 'Unknown error occurred'));
                }
            })
            .catch(error => {
                console.error('Fetch error:', error);
                alert('Network error occurred. Please check your connection and try again.');
            })
            .finally(() => {
                // Reset button state
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
            });
    });
</script>

<?php require_once 'includes/footer.php'; ?>