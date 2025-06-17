 <!-- Submit Buttons -->
                    <div class="flex space-x-4">
                        @if(isset($vehicles))
                            <button type="submit"
                                class="flex-1 bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200">
                                Submit Order
                            </button>
                        @endif
                        <a href="{{ route('kendaraan') }}"
                            class="flex-1 bg-gray-300 text-gray-700 py-2 px-4 rounded-md text-center hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition duration-200">
                            {{ isset($vehicles) ? 'Change Vehicle' : 'Select Vehicle' }}
                        </a>
                    </div>