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
            <div class="w-2/3">
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
                        <tbody>

                            @foreach($images as $image)
                                @if(\Illuminate\Support\Facades\Storage::disk('dropbox')->exists('images/'.$image->img_url))
                                <tr class="bg-white dark:bg-gray-800 border-b">
                                    <td class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <div class="w-[150px] h-[100px] border overflow-hidden">
                                            <img src="{{ \Illuminate\Support\Facades\Storage::disk('dropbox')->url('images/'.$image->img_url)  }}" alt="" class="w-full h-full">
                                        </div>
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="text-center flex items-center gap-2">
                                            <a href="#" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Edit</a>
                                            <form action="{{ route('dropbox.image-delete', \Illuminate\Support\Facades\Crypt::encrypt($image->id) ) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Delete</button>
                                            </form>
                                        </div>


                                    </td>
                                </tr>
                                @endif
                            @endforeach


                        </tbody>
                    </table>
                    <div class="p-2">
                        {{ $images->links('vendor.pagination.tailwind') }}
                    </div>

                </div>

            </div>
            <div class="w-1/3">
                <form action="{{ route('dropbox.image.store') }}" method="POST" enctype="multipart/form-data" id="imageUploadFrom">
                    @csrf
                    <div class="flex justify-center items-center w-full" x-data="imgPreview" x-cloak>
                        <label for="dropzone-file" class="flex flex-col justify-center items-center w-full h-64 bg-gray-50 rounded-lg border-2 border-gray-300 border-dashed cursor-pointer dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                            <template x-if="imgsrc">
                                <img :src="imgsrc" alt="" class="w-full h-full p-0.5 rounded">
                            </template>
                            <template x-if="!imgsrc">
                                <div  class="flex flex-col justify-center items-center pt-5 pb-6">
                                    <svg aria-hidden="true" class="mb-3 w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (MAX. 800x400px)</p>
                                </div>
                            </template>
                            <input id="dropzone-file" type="file" name="image" class="hidden" accept="image/*" x-ref="myFile" @change="previewFile">
                        </label>
                    </div
                    @error('image')
                    <p class="text-rose-600">{{ $message }}</p>
                    @enderror
                    <br>
                    <button type="submit" class="mt-4 flex items-center gap-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                        </svg>Upload</button>


                </form>
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
