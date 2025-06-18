<!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-end">
                    <button 
                        type="button" 
                        id="cancel-btn"
                        class="px-6 py-3 border-2 border-gray-300 text-gray-700 font-roboto font-semibold rounded-xl hover:bg-gray-50 transition-colors duration-200"
                    >
                        Batal
                    </button>
                    
                    <button 
                        type="submit" 
                        id="submit-btn"
                        class="px-8 py-3 bg-green-600 text-white font-roboto font-semibold rounded-xl hover:bg-green-700 focus:outline-none focus:ring-4 focus:ring-blue-200 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                        <span id="submit-text">Kirim Feedback</span>
                        <span id="loading-text" class="hidden">Mengirim...</span>
                    </button>
                </div>