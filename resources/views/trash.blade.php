<x-app-layout>
    <div class="my-12">
        @if(session()->has('success_msg'))
            <div class="flex justify-center">
                <div id="alert-3" class="flex p-4 mb-4 bg-green-100 rounded-lg dark:bg-green-200" role="alert">
                    <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-green-700 dark:text-green-800" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                    <span class="sr-only">Info</span>
                    <div class="ml-3 text-sm font-medium text-green-700 dark:text-green-800">
                        {{ session()->get('success_msg') }}
                    </div>
                    <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-green-100 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex h-8 w-8 dark:bg-green-200 dark:text-green-600 dark:hover:bg-green-300" data-dismiss-target="#alert-3" aria-label="Close">
                        <span class="sr-only">Close</span>
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </button>
                </div>
            </div>
        @endif
        <div class="flex justify-between gap-4 w-full">
            <div class="w-full">
                <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="py-3 px-6 w-2/3">
                               Image
                            </th>
                            <th scope="col" class="py-3 px-6 text-center w-1/3">
                               Action
                            </th>
                        </tr>
                        </thead>
                        <tbody x-data="{full: false}">
                            @foreach($images as $image)
                                @if($image)
                                <tr class="bg-white dark:bg-gray-800 border-b">
                                    <td class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white flex gap-2 items-center">
                                      <p x-show="full === false">{{ \Illuminate\Support\Str::limit($image, 60) }} </p>
                                        <p x-show="full">{{$image }} </p>
                                        <button x-show="full === false" @click="full = true" class="text-green-400">show full</button>
                                        <button x-show="full" @click="full = false" class="text-green-400">hide full</button>
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="text-center flex items-center gap-2">
                                            <a href="{{ route('dropbox.image-restore', $image) }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Restore</a>
                                            <form action="#" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Permanently delete </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                    <div class="p-2">
{{--                        {{ $deleted_images->links('vendor.pagination.tailwind') }}--}}
                    </div>

                </div>

            </div>
        </div>
    </div>
@push('script')
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('imgPreview', () => ({
                    imgsrc:null,
                    previewFile() {
                        let file = this.$refs.myFile.files[0];
                        if(!file || file.type.indexOf('image/') === -1) return;
                        this.imgsrc = null;
                        let reader = new FileReader();

                        reader.onload = e => {
                            this.imgsrc = e.target.result;
                        }

                        reader.readAsDataURL(file);

                    }
                }))
            });

        </script>
@endpush

</x-app-layout>
