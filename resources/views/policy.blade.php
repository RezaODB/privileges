@extends('layouts.front')

@section('content')

<section class="bg-[#fdf2e3] p-3 pb-16 shadow-xl rounded-3xl">

    <h2 class="text-right text-2xl sm:text-4xl font-light mb-8">{{ Auth::user()->order ?? 'X' }}/250</h2>
        
    <div class="font-mono mb-4 px-2 sm:px-8" x-data="{ open: false }">
        <div class="flex items-baseline justify-between gap-4 border-zinc-800 border-b-4 pb-4 cursor-pointer" x-on:click="open = !open">
            @if (app()->isLocale('fr'))
            <h1 class="text-2xl font-sans uppercase">Accord de participation</h1>
            @endif
            @if (app()->isLocale('en'))
            <h1 class="text-2xl font-sans uppercase">Participation agreement</h1>
            @endif
            <h2 x-text="open ? '(- Close)' : '(+ Open)'" class="whitespace-nowrap"></h2>
        </div>
        <div x-show="open" x-collapse>
            <div class="flex lg:divide-x-2 divide-zinc-800">
                <div class="h-12 flex-1"></div>
                <div class="h-12 flex-1"></div>
            </div>
            <div class="pb-12 prose max-w-none columns-md gap-12 [column-rule:2px_solid_#27272a] prose-h1:break-after-avoid prose-h2:break-after-avoid prose-h3:break-after-avoid prose-ol:ml-4 prose-li:text-justify prose-a:underline prose-p:text-justify prose-h2:font-sans prose-h2:text-2xl prose-h2:uppercase prose-h2:font-normal prose-h2:border-b-2 prose-h2:border-zinc-800 prose-h2:pb-4 prose-h2:-mx-6 prose-h2:px-6 prose-h3:font-sans prose-h3:uppercase prose-h3:font-medium prose-h3:text-lg prose-blockquote:border-y-2 prose-blockquote:border-x-0 prose-blockquote:border-zinc-800 prose-blockquote:-mx-6 prose-blockquote:text-xl prose-blockquote:uppercase prose-blockquote:py-2 prose-blockquote:px-6 prose-blockquote:not-italic prose-blockquote:text-center prose-blockquote:text-[#374151] overflow-hidden">
                @if (app()->isLocale('fr'))
                <h3>Merci de participer à mon projet artistique Les Privilèges Invisibles !</h3>
                <p>Je travaille sur ce projet en amont depuis 2 ans et j'ai tellement hâte de commencer cette étude titanesque avec toutes les personnes qui ont compté pour moi à un moment de ma vie.</p>
                <p>À travers une étude photographique et plastique (ci-après, l' "Œuvre") impliquant +/- 250 participants, je souhaite explorer comment le hasard, la chance et les privilèges façonnent nos vies de manière souvent inconsciente.</p>
                <p>Dans la mesure où tu vas remplir un questionnaire reprenant des informations qui te concernent, cet accord est une simple formalité pour m'assurer que je peux utiliser ce contenu te concernant (photos/vidéos que je vais capturer en vue de les intégrer à l'Œuvre et les informations que tu m'auras partagées) dans le cadre du projet "Les Privilèges Invisibles", ci-après "le Projet". Ce que ça veut dire: </p>
                <ol>
                    <li>En signant ce document, tu m'autorises à utiliser les photos et ou les vidéos que j'aurai prise de toi pour les besoins de la production et de la diffusion du Projet et de l'Œuvre. Tu m'autorises également à utiliser les informations que tu auras partagé sur toi dans le cadre de mon Projet. Il s'agit des informations personnelles en lien avec tes origines, ta vie, ton orientation, etc. Tu trouveras tous les détails dans la politique de protection des données que tu peux consulter en annexe. En ce qui concerne l'Œuvre, cela inclut des publications sur internet, dans la presse, pour des expositions, des musées, des festivals, vente de l'œuvre ou prints en édition numéroté, etc, et plus globalement toute exploitation utile de l' Œuvre, et ce partout dans le monde.</li>
                    <li>En aucun cas, ton nom et prénom ne sera jamais révélé ni dans l'Œuvre ni dans la presse. Par contre, ton portrait photographique fera intégralement partie de l'Œuvre finale du Projet.</li>
                    <li>Comme ce projet repose sur la contribution de nombreuses personnes et que chaque présence compte pour l'équilibre de l'Œuvre, je te demande de rester engagé tout au long de cette aventure, afin de préserver la vision collective qui la sous-tend.</li>
                    <li>Il va sans dire que je n'utiliserai jamais les photos sur lesquelles tu apparais sans ton autorisation à d'autres fins que l'exploitation de l'Œuvre.</li>
                    <li>Durée de l'Autorisation: cette autorisation est indéterminée, sans limite de temps.</li>
                    <li>Pas de Rémunération: cette participation est bénévole. Il n'y a donc pas de compensation financière pour ta participation au Projet.</li>
                    <li>Où ça s'applique: cette autorisation est valable partout dans le monde.</li>
                </ol>
                <p>L'artiste se réserve la liberté artistique de décider des orientations et évolutions du projet, ce qui peut inclure des ajustements concernant les contributions individuelles, en fonction des besoins créatifs ou organisationnels.</p>    
                <p>Encore merci pour ta participation à ce projet tellement personnel ! Pour le bon ordre, je reprends quelques conditions générales et la politique de protection des données ci-après.</p>
                @endif
                @if (app()->isLocale('en'))
                <h3>Thank you for participating in my artistic project Les Privilèges Invisibles!</h3>
                <p>I have been working on this project for over two years and am so excited to start this monumental study with all the people who have meant something to me at some point in my life.</p>
                <p>Through a photographic and sculptural study (hereafter referred to as the "Work") involving 250 participants, I aim to explore how chance, luck, and privilege unconsciously shape our lives.</p>
                <p>Since you will be completing a questionnaire containing personal information, this agreement is a simple formality to ensure I can use this content (photos/videos I will capture, and the information you share with me) as part of the project Les Privilèges Invisibles, hereafter referred to as "the Project." What this means: </p>
                <ol>
                    <li>By signing this document, you authorize me to use the photos and/or videos I take of you for the production and dissemination of the Project and the Work.You also authorize me to use the personal information you share about yourself for the Project. This includes personal information related to your background, life, orientation, etc. You can find all the details in the data protection policy attached. Regarding the Work, this includes publications on the internet, in the press, in exhibitions, museums, festivals, sales of the artwork or numbered print editions, and any other uses of the Work worldwide.</li>
                    <li>Your name and surname will never be disclosed, either in the Work or in the press. However, your photographic portrait will be an integral part of the final Work of the Project.</li>
                    <li>Given that this project depends on the contributions of many people and that each participant is essential to the balance of the Work, I ask you to remain committed throughout this journey to preserve the collective vision underlying it.</li>
                    <li>It goes without saying that I will never use the photos of you for purposes other than the Work, without your consent.</li>
                    <li>Duration of Authorization: This authorization is indefinite, without any time limit.</li>
                    <li>No Compensation: Participation in this project is voluntary. There is no financial compensation for your involvement in the Project.</li>
                    <li>Scope of Application: This authorization is valid worldwide.
                    </li>
                </ol>
                <p>The artist reserves the artistic freedom to decide on the directions and developments of the project, which may include adjustments to individual contributions based on creative or organizational needs.</p>
                <p>Thank you again for participating in this deeply personal project! To formalize everything, I include some general conditions and the data protection policy below.</p>
                @endif
            </div>
        </div>
    </div>

    <div class="font-mono mb-4 px-2 sm:px-8" x-data="{ open: false }">
        <div class="flex items-baseline justify-between gap-4 border-zinc-800 border-b-4 pb-4 cursor-pointer" x-on:click="open = !open">
            @if (app()->isLocale('fr'))
            <h1 class="text-2xl font-sans uppercase">Droits intellectuels, droit à l'image et politique de protection des données</h1>
            @endif
            @if (app()->isLocale('en'))
            <h1 class="text-2xl font-sans uppercase">INTELLECTUAL PROPERTY, IMAGE RIGHTS, AND DATA PROTECTION POLICY</h1>
            @endif
            <h2 x-text="open ? '(- Close)' : '(+ Open)'" class="whitespace-nowrap"></h2>
        </div>
        <div x-show="open" x-collapse>
            <div class="flex lg:divide-x-2 divide-zinc-800">
                <div class="h-12 flex-1"></div>
                <div class="h-12 flex-1"></div>
            </div>
            <div class="pb-12 prose max-w-none columns-md gap-12 [column-rule:2px_solid_#27272a] prose-h1:break-after-avoid prose-h2:break-after-avoid prose-h3:break-after-avoid prose-ol:ml-4 prose-li:text-justify prose-a:underline prose-p:text-justify prose-h2:font-sans prose-h2:text-2xl prose-h2:uppercase prose-h2:font-normal prose-h2:border-b-2 prose-h2:border-zinc-800 prose-h2:pb-4 prose-h2:-mx-6 prose-h2:px-6 prose-h3:font-sans prose-h3:uppercase prose-h3:font-medium prose-h3:text-lg prose-blockquote:border-y-2 prose-blockquote:border-x-0 prose-blockquote:border-zinc-800 prose-blockquote:-mx-6 prose-blockquote:text-xl prose-blockquote:uppercase prose-blockquote:py-2 prose-blockquote:px-6 prose-blockquote:not-italic prose-blockquote:text-center prose-blockquote:text-[#374151] overflow-hidden">
                @if (app()->isLocale('fr'))
                <h3>Identification</h3>
                <p>Les conditions générales sont applicables entre vous en tant que participant (ci-après le Participant) dans le cadre du Projet Les Privilèges Invisibles et Madame Barbara Iweins dont les coordonnées sont 11, Rue Antoine Labarre – 1050 Bruxelles ci-après désignée par "l'Artiste".</p>
                <h3>Application des présentes conditions générales</h3>
                <p>Le fait de cocher la case prévue à cet effet implique l'acceptation expresse et irrévocable des présentes conditions générales par le Participant, nonobstant toutes stipulations contraires figurant sur toute correspondance émanant du participant, sauf acceptation formelle et écrite de l'Artiste. Les présentes conditions générales priment sauf accord exprès, écrit et préalable de l'Artiste.</p>
                <h3>Propriété de l'Œuvre dans le cadre du Projet</h3>
                <p>Les créations de l'Artiste dans le cadre du Projet, comme par exemple, les écrits, les maquettes, les croquis et avant-projets, les photos quels qu'en soit le tirages, la qualité ou le support, sont et restent la propriété exclusive matérielle et intellectuelle de l'Artiste.</p>
                <h3>Droit d'auteur ou de reproduction</h3>
                <p>Le Projet, dont notamment l' Œuvre, créé par l'Artiste est protégé par les droits d'auteur. En aucun cas, tout ou partie de ces droits ne sont cédés au participant sauf accord expresse et écrit spécifique sur ce point entre les parties.</p>
                <h3>Droit à l'image</h3>
                <p>Le Participant concède une autorisation d'exploitation de son image sans limite de temps ni de durée pour les besoins du Projet, la création de l'Œuvre et sa diffusion/communication au public au sens le plus large.</p>
                <h3>Protection des données personnelles</h3>
                <p>L'Artiste est le responsable du traitement des données personnelles collectées auprès de ses participants.</p>
                <p>Les informations collectées auprès des participants sont les suivantes: nom, prénom, fonction, adresse mail, téléphone et mobile, ainsi que des données liées à l'âge, le genre, l'orientation sexuelle, la situation familiale, l'origine, la santé, l'opinion, le style vestimentaire (mode), et le comportement social.</p>
                <p>Les données visées sont communiquées directement par le Participant et avec son accord. Elles sont destinées à l'usage de l'Artiste quant à l'exécution du contrat, le développement du Projet, la création et la diffusion de l'Œuvre. Ces données ne sont en aucun cas susceptibles d'être transmises à des sous-traitants ou des tiers. Les données ne sont en aucun cas susceptible d'être utilisées dans le cadre d'un marketing direct ou indirect. En aucun cas, l'Artiste n'est responsable d'éventuelles mésinterprétions ou usages abusifs des images ou des données par des tiers en dehors de son contrôle.</p>
                <p>L'Artiste garantit le respect des données personnelles et se conforme strictement au Règlement (UE) 2016/679 du Parlement européen et du conseil du 27 avril 2016 relatif à la protection des personnes physiques à l'égard du traitement des données à caractère personnel et à la libre circulation de ces données, et abrogeant la directive 95/46/CE. Les données sont collectées pour les besoins contractuels entre les parties dans le cadre du Projet, et pour remplir leurs obligations légales.</p>
                <p>Conformément à la réglementation en vigueur, en tant que personne physique, le Participant a le droit d'accéder à ses données personnelles, de les corriger, d'en demander la suppression, le droit de limiter leur traitement et de s'opposer à leur traitement à des fins de marketing direct. Le participant a également le droit à la portabilité des données, c'est-à-dire qu'elles soient communiquées dans un format structuré courant. L'exercice de ces droits est gratuit. Le cas échéant, le Participant peut adresser une demande afin d'exercer l'un ou l'autre de ces droits ou signaler une difficulté ou un problème qui concerne ses données via l'adresse suivante: </p>
                <p>
                Adresse: 11, Rue Antoine Labarre – 1050 Bruxelles<br>
                Tel: + 32 472612641<br>
                Courriel: barbara.iweins@gmail.com<br>
                </p>
                <p>Le participant dispose également du droit d'introduire une réclamation auprès de l'Autorité de protection des données (<a href="https://www.autoriteprotectiondonnees.be" target="_blank">www.autoriteprotectiondonnees.be</a>). Le cas échéant, le Participant peut adresser un simple e-mail afin d'exercer l'un ou l'autre de ses droits.</p>
                <p>Les données personnelles collectées ne seront conservées que pendant le temps nécessaire pour rencontrer les finalités indiquées ou pour respecter les obligations légales. Une fois votre dossier clôturé, vos données sont stockées pour une durée de 10 ans maximum, à compter de la fin de la diffusion du Projet. Au-delà, elles seront détruites (effacement du fichier numérique contenant les données).</p>
                <p>Dans les limites exposées ci-dessus, le Participant autorise donc expressément l'Artiste à conserver et à traiter les données personnelles communiquées dans le cadre du Projet et de la création et la diffusion de l'Œuvre.</p>
                <h3>Droit applicable et tribunaux compétents</h3>
                <p>Les relations contractuelles entre parties auxquelles s'appliquent les présentes conditions sont régies exclusivement par le droit belge. Les parties conviennent de s'efforcer de régler à l'amiable tous les problèmes qui pourraient survenir concernant le présent contrat, par a minima une invitation en médiation. Passé ce délai les cours et tribunaux francophones de l'arrondissement judiciaire de Bruxelles seront seuls compétents.</p>
                @endif
                @if (app()->isLocale('en'))
                <h3>Identification</h3>
                <p>The general terms and conditions are applicable between you as a participant (hereinafter referred to as the Participant) within the framework of the Les Privilèges Invisibles project and Ms. Barbara Iweins, whose contact details are 11, Rue Antoine Labarre – 1050 Brussels (hereinafter referred to as "the Artist").</p>
                <h3>Application of These General Terms and Conditions</h3>
                <p>By ticking the relevant box, the Participant expressly and irrevocably accepts these general terms and conditions, notwithstanding any contrary stipulations contained in correspondence from the Participant, unless formally and expressly accepted in writing by the Artist. These general terms and conditions take precedence unless expressly agreed otherwise in writing and in advance by the Artist.</p>
                <h3>Ownership of the Artwork Within the Project Framework</h3>
                <p>The Artist's creations within the framework of the Project, such as writings, models, sketches and preliminary projects, photos regardless of their prints, quality, or medium, are and remain the exclusive material and intellectual property of the Artist.</p>
                <h3>Copyright or Reproduction Rights</h3>
                <p>The Project, including but not limited to the Artwork created by the Artist, is protected by copyright. Under no circumstances are any of these rights, in whole or in part, transferred to the Participant unless specifically and expressly agreed upon in writing between the parties.</p>
                <h3>Image Rights</h3>
                <p>The Participant grants authorization for the use of their image without any time or duration limitation for the purposes of the Project, the creation of the Artwork, and its dissemination/communication to the public in the broadest sense.</p>
                <h3>Personal Data Protection</h3>
                <p>The Artist is the data controller for personal data collected from participants.</p>
                <p>The information collected from participants includes: name, first name, function, email address, phone and mobile numbers, as well as data related to age, gender, sexual orientation, family situation, origin, health, opinions, clothing style (fashion), and social behavior.</p>
                <p>The data is provided directly by the Participant with their consent. It is intended for the Artist's use concerning the execution of the contract, the development of the Project, the creation, and dissemination of the Artwork. This data will not, under any circumstances, be transmitted to subcontractors or third parties. It will also not be used for direct or indirect marketing purposes. The Artist is not responsible for any potential misinterpretation or misuse of images or data by third parties outside of their control.</p>
                <p>The Artist ensures compliance with personal data protection and strictly adheres to Regulation (EU) 2016/679 of the European Parliament and Council of April 27, 2016, on the protection of natural persons with regard to the processing of personal data and on the free movement of such data, repealing Directive 95/46/EC. Data is collected to meet contractual requirements between the parties within the Project's framework and to fulfill legal obligations.</p>
                <p>In accordance with current regulations, as a natural person, the Participant has the right to access their personal data, correct it, request its deletion, limit its processing, and object to its processing for direct marketing purposes. The Participant also has the right to data portability, meaning the data can be provided in a commonly structured format. Exercising these rights is free of charge. If necessary, the Participant can send a request to exercise any of these rights or report an issue concerning their data using the following contact details: </p>
                <p>Address: 11, Rue Antoine Labarre – 1050 Brussels <br>
                    Phone: +32 472612641 <br>
                    Email: barbara.iweins@gmail.com</p>
               <p>The Participant also has the right to lodge a complaint with the Data Protection Authority (<a href="www.autoriteprotectiondonnees.be" target="_blank">www.autoriteprotectiondonnees.be</a> ). If necessary, the Participant can simply send an email to exercise any of their rights.</p>
               <p>Collected personal data will only be kept as long as necessary to meet the stated purposes or fulfill legal obligations. Once the file is closed, the data will be stored for a maximum of 10 years from the end of the Project's dissemination. After that, it will be destroyed (deletion of the digital file containing the data).</p>
               <p>Within the limits outlined above, the Participant expressly authorizes the Artist to retain and process the personal data provided within the framework of the Project and the creation and dissemination of the Artwork.</p>
               <h3>Applicable Law and Competent Courts</h3>
               <p>The contractual relationships between the parties to which these terms apply are governed exclusively by Belgian law. The parties agree to attempt to resolve any issues arising from this contract amicably, at a minimum through an invitation to mediation. Failing this, the French-speaking courts and tribunals of the judicial district of Brussels will have sole jurisdiction.</p>
                @endif
            </div>
        </div>
    </div>
    

</section>

@endsection