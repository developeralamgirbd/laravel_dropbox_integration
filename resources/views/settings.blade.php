<x-app-layout>

        @if(session()->has('success'))
        <div class="flex justify-center">
            <div id="alert-3" class="flex p-4 mb-4 bg-green-100 rounded-lg dark:bg-green-200" role="alert">
                <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-green-700 dark:text-green-800" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                <span class="sr-only">Info</span>
                <div class="ml-3 text-sm font-medium text-green-700 dark:text-green-800">
                    {{ session()->get('success') }}
                </div>
                <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-green-100 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex h-8 w-8 dark:bg-green-200 dark:text-green-600 dark:hover:bg-green-300" data-dismiss-target="#alert-3" aria-label="Close">
                    <span class="sr-only">Close</span>
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>
            </div>
        </div>
        @endif

    <div class="flex justify-center">
        <div class="w-2/4 bg-white rounded p-4 border">
            <form action="{{ route('dropbox.store') }}" method="POST" >
                @csrf
                <div class="relative z-0 mb-6 w-full group">
                    <input type="text" name="app_key" id="app_key" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-b border-t-0 border-r-0 border-l-0  border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" ">
                    <label for="app_key" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">App key</label>
                    @error('app_key')
                        <p class="text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="relative z-0 mb-6 w-full group">
                    <input type="text" name="app_secret" id="app_secret" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-b border-t-0 border-r-0 border-l-0  border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" ">
                    <label for="app_secret" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">App secret</label>
                    @error('app_secret')
                    <p class="text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="relative z-0 mb-6 w-full group">
                    <input type="text" name="notify_email" id="notifyEmail" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-b border-t-0 border-r-0 border-l-0  border-b-gray-300 appearance-none dark:text-white dark:border-b-gray-600 dark:focus:border-b-blue-500 focus:outline-none focus:ring-0 focus:border-b-blue-600 peer" placeholder=" ">
                    <label for="notifyEmail" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Notification Email</label>

                </div>
                <div class="my-3 ">
                    <div class="flex gap-2 items-center">
                        <label for="">Redirect URL: </label>
                        <input type="hidden" name="redirect_url" id="redirectUrl" value="{{ $_SERVER['SERVER_NAME']. '/dropbox-authorize' }}" class="border-0">
                        <p id="showRedirectUrl"></p>

                    </div>

                    @error('redirect_url')
                    <p class="text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
            </form>
        </div>

    </div>

    <script type="text/javascript">
        const redirectUrl = window.location.origin+'/dropbox-authorize';
        const redirectUrlInput = document.getElementById('redirectUrl');
        const redirectUrlShow = document.getElementById('showRedirectUrl');
        redirectUrlInput.value = redirectUrl;
        redirectUrlShow.innerText = redirectUrl;

    </script>
</x-app-layout>
