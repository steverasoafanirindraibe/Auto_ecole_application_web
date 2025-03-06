import Header from "@/components/ui/Header"
import Input from "@/components/ui/Input";

export default function Inscription() {
    return (
        <main className="h-full w-full bg-background-100 dark:bg-foreground-100 flex flex-col items-center">
            <Header></Header>
            <div className="text-white dark:text-background-100 w-5/6 h-full flex justify-center" >
                <div className="py-8" >
                    <div className="text-lg italic text-center py-6" >- Information a retenir -</div>
                    <div className="text-sm" >Lorem ipsum, dolor sit amet consectetur adipisicing elit. Pariatur tempore odio sapiente modi totam ducimus qui porro doloremque culpa vel quo, cumque nobis saepe quos, eligendi dicta quae. Doloribus, molestiae eaque. Nulla labore tenetur dolorem nisi debitis magni, nihil, adipisci, recusandae pariatur repellat voluptatum rerum totam enim odit. Hic odio atque ad illo optio neque eveniet voluptatibus sequi exercitationem odit quas dolor cumque laudantium distinctio eius, unde quo harum culpa maiores voluptates impedit? Earum iste sit animi labore minus, soluta alias cupiditate eius ipsum placeat omnis odit ut voluptate reiciendis quaerat nihil, dignissimos reprehenderit asperiores pariatur! Id ea voluptas quod!</div>
                </div>
            </div>
            <div className="h-full w-full flex justify-center items-center text-white dark:text-background-100 py-6" >
                <div className="w-5/6 h-full flex flex-col md:flex-row" >
                    <div className="h-full md:w-1/3 w-full pr-10" >
                        <div className="text-lg px-4 py-4">A propos de formation :</div>
                        <div className=" bg-background-200 dark:bg-foreground-200 rounded-lg text-sm text-gray-500" >
                            <ul>
                                <li>
                                    <div className=" font-semibold" >Type de permis</div>
                                    <div className="" ></div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div className="h-full md:w-2/3 w-full pl-10 flex flex-wrap" >
                        <div className="w-[40%] pl-6 pt-4" >
                            <Input label="Name" placeholder="" className="text-white dark:text-black bg-background-200 dark:bg-foreground-200" ></Input>
                        </div>
                        <div className="w-[40%] pl-6 pt-4" >
                            <Input label="Name" placeholder="" className="text-white dark:text-black bg-background-200 dark:bg-foreground-200" ></Input>
                        </div>
                        <div className="w-[40%] pl-6 pt-4" >
                            <Input label="Name" placeholder="" className="text-white dark:text-black bg-background-200 dark:bg-foreground-200" ></Input>
                        </div>
                        <div className="w-[40%] pl-6 pt-4" >
                            <Input label="Name" placeholder="" className="text-white dark:text-black bg-background-200 dark:bg-foreground-200" ></Input>
                        </div>
                        <div className="w-[40%] pl-6 pt-4" >
                            <Input label="Name" placeholder="" className="text-white dark:text-black bg-background-200 dark:bg-foreground-200" ></Input>
                        </div>
                    </div>
                </div>
               

            </div>
        </main>
    )
}