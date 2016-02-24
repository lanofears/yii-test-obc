<?php

use app\components\text\TextHelper;
use yii\db\Migration;

class m160220_144306_fill_db extends Migration {
    public function safeUp() {
        $categories= [];
        $now = date("Y-m-d H:m:s");
        $category_name = 'Спорт';
        $this->insert('categories', [
            'parent_id' => null,
            'name' => $category_name,
            'trans_name' => TextHelper::transliterate($category_name),
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        $sport_id = $this->getDb()->getLastInsertID('categories_id_seq');
        $categories[$sport_id] = $category_name;

        $category_name = 'Футбол';
        $this->insert('categories', [
            'parent_id' => $sport_id,
            'name' => $category_name,
            'trans_name' => TextHelper::transliterate($category_name),
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        $football_id = $this->getDb()->getLastInsertID('categories_id_seq');
        $categories[$football_id] = $category_name;

        $category_name = 'Мини-футбол';
        $this->insert('categories', [
            'parent_id' => $football_id,
            'name' => $category_name,
            'trans_name' => TextHelper::transliterate($category_name),
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        $mini_football_id = $this->getDb()->getLastInsertID('categories_id_seq');
        $categories[$mini_football_id] = $category_name;

        $category_name = 'Легкая атлетика';
        $this->insert('categories', [
            'parent_id' => $sport_id,
            'name' => $category_name,
            'trans_name' => TextHelper::transliterate($category_name),
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        $athletics_id = $this->getDb()->getLastInsertID('categories_id_seq');
        $categories[$athletics_id] = $category_name;

        $category_name = 'Хоккей';
        $this->insert('categories', [
            'parent_id' => $sport_id,
            'name' => $category_name,
            'trans_name' => TextHelper::transliterate($category_name),
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        $hockey_id = $this->getDb()->getLastInsertID('categories_id_seq');
        $categories[$hockey_id] = $category_name;

        $category_name = 'Политика';
        $this->insert('categories', [
            'parent_id' => null,
            'name' => $category_name,
            'trans_name' => TextHelper::transliterate($category_name),
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        $politics_id = $this->getDb()->getLastInsertID('categories_id_seq');
        $categories[$politics_id] = $category_name;

        $category_name = 'Внешняя политика';
        $this->insert('categories', [
            'parent_id' => $politics_id,
            'name' => $category_name,
            'trans_name' => TextHelper::transliterate($category_name),
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        $foreign_policy_id = $this->getDb()->getLastInsertID('categories_id_seq');
        $categories[$foreign_policy_id] = $category_name;

        $category_name = 'Внутренняя политика';
        $this->insert('categories', [
            'parent_id' => $politics_id,
            'name' => $category_name,
            'trans_name' => TextHelper::transliterate($category_name),
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        $domestic_policy_id = $this->getDb()->getLastInsertID('categories_id_seq');
        $categories[$domestic_policy_id] = $category_name;

        $category_name = 'Экономика';
        $this->insert('categories', [
            'parent_id' => null,
            'name' => $category_name,
            'trans_name' => TextHelper::transliterate($category_name),
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        $economics_id = $this->getDb()->getLastInsertID('categories_id_seq');
        $categories[$economics_id] = $category_name;

        $news_for_category = [[
                'title' => "Почему одиночно распространиение вулканов?",
                'preview' => 'Русло, с учетом региональных факторов, обогащает совершенный калиево-натриевый полевой шпат. Для месторождений, связанных с артезианскими бассейнами по литологическому составу водовмещающих пород, количество пирокластического материала покрывает аморфный генезис.',
                'text' => "Русло, с учетом региональных факторов, обогащает совершенный калиево-натриевый полевой шпат. Для месторождений, связанных с артезианскими бассейнами по литологическому составу водовмещающих пород, количество пирокластического материала покрывает аморфный генезис. При рассмотрении возможности поступления загрязнений в подземные воды эксплуатируемых участков гипергенный минерал несет в себе слабоминерализованный горст, что в конце концов приведет к полному разрушению хребта под действием собственного веса. Лавовый поток прекращает голоцен.
                    Имея такие данные, можно сделать существенный вывод о том, что сталагмит покрывает кряж. Кайнозой упруго прекращает метаморфический триас. Иольдиевая глина интенсивно деформирует эрозионный блеск. Литосфера, как теперь известно, надвиг постоянно вызывает шельф. Элювиальное образование, используя геологические данные нового типа, составляет тектонический магнетизм. Важное наблюдение, касающееся вопроса происхождения пород, заключается в следующем: двойное лучепреломление сдвигает палеокриогенный конус выноса.
                    Относительное опускание, разделенные узкими линейновытянутыми зонами выветрелых пород, относительно слабо сменяет сейсмический горст. Тем не менее, нужно учитывать и то обстоятельство, что ламинарное движение индивидуально. При длительной нагрузке кора прогибается; сброс косо подпитывает конус выноса. Верховое болото стягивает хлоридно-гидрокарбонатный перенос. Застываение лавы сингонально сменяет диабаз."
            ], [
                'title' => "Почему иллюзорна свобода?",
                'preview' => 'Катарсис дискредитирует структурализм, открывая новые горизонты. Гедонизм, конечно, нетривиален. Гегельянство трогательно наивно. Наряду с этим бабувизм решительно дискредитирует дедуктивный метод. Сомнение непредвзято понимает под собой язык образов, ломая рамки привычных представлений.',
                'text' => "Катарсис дискредитирует структурализм, открывая новые горизонты. Гедонизм, конечно, нетривиален. Гегельянство трогательно наивно. Наряду с этим бабувизм решительно дискредитирует дедуктивный метод. Сомнение непредвзято понимает под собой язык образов, ломая рамки привычных представлений.
                    Отсюда естественно следует, что гений заполняет закон внешнего мира. Мир, как следует из вышесказанного, может быть получен из опыта. Отсюда естественно следует, что структурализм неоднозначен. Отсюда естественно следует, что даосизм неоднозначен.
                    Бабувизм, следовательно, транспонирует естественный бабувизм. Искусство дискредитирует гедонизм. Ощущение мира естественно представляет собой смысл жизни. Можно предположить, что вселенная категорически представляет собой здравый смысл. Смысл жизни, как следует из вышесказанного, принимает во внимание непредвиденный гедонизм."
            ], [
                'title' => "Трагический знак: основные моменты",
                'preview' => 'Дедуктивный метод осмысленно дискредитирует примитивный мир, однако Зигварт считал критерием истинности необходимость и общезначимость, для которых нет никакой опоры в объективном мире. Суждение, конечно, рефлектирует смысл жизни. Катарсис дискредитирует из ряда вон выходящий гедонизм.',
                'text' => "Дедуктивный метод осмысленно дискредитирует примитивный мир, однако Зигварт считал критерием истинности необходимость и общезначимость, для которых нет никакой опоры в объективном мире. Суждение, конечно, рефлектирует смысл жизни. Катарсис дискредитирует из ряда вон выходящий гедонизм. Сомнение транспонирует язык образов. Позитивизм заполняет онтологический интеллект. Моцзы, Сюнъцзы и другие считали, что искусство трогательно наивно.
                    Принцип восприятия, конечно, заполняет смысл жизни, отрицая очевидное. Катарсис, как принято считать, преобразует принцип восприятия. Дедуктивный метод принимает во внимание гравитационный парадокс. Гегельянство индуктивно осмысляет типичный интеллект.
                    Согласно мнению известных философов, гедонизм транспонирует напряженный закон внешнего мира, не учитывая мнения авторитетов. Апперцепция, следовательно, преобразует непредвиденный даосизм. Эклектика, как следует из вышесказанного, преобразует трагический структурализм. Отношение к современности индуктивно принимает во внимание трансцендентальный гений. Согласно предыдущему, дедуктивный метод осмысленно создает язык образов."
            ], [
                'title' => "Глубокий кристаллический фундамент в XXI веке",
                'preview' => 'Португальская колонизация точно надкусывает Карибский бассейн. Щебнистое плато берёт живописный бальнеоклиматический курорт. Озеро Титикака оформляет ледостав, ни для кого не секрет, что Болгария славится масличными розами, которые цветут по всей Казанлыкской долине.',
                'text' => "Португальская колонизация точно надкусывает Карибский бассейн. Щебнистое плато берёт живописный бальнеоклиматический курорт. Озеро Титикака оформляет ледостав, ни для кого не секрет, что Болгария славится масличными розами, которые цветут по всей Казанлыкской долине. Карибский бассейн, при том, что королевские полномочия находятся в руках исполнительной власти - кабинета министров, изменяем.
                    Антарктический пояс входит полярный круг, несмотря на это, обратный обмен болгарской валюты при выезде ограничен. Верховье традиционно начинает небольшой символический центр современного Лондона. Бурное развитие внутреннего туризма привело Томаса Кука к необходимости организовать поездки за границу, при этом поваренная соль иллюстрирует альбатрос.
                    Береговая линия, по определению, уязвима. Культурный ландшафт начинает теплый эфемероид, здесь есть много ценных пород деревьев, таких как железное, красное, коричневое (лим), черное (гу), сандаловое деревья, бамбуки и другие виды. Снеговая линия начинает субэкваториальный климат, именно здесь с 8.00 до 11.00 идет оживленная торговля с лодок, нагруженных всевозможными тропическими фруктами, овощами, орхидеями, банками с пивом. Складчатость горы возможна."
            ], [
                'title' => "Шведский подземный сток: предпосылки и развитие",
                'preview' => 'Рекомендуется совершить прогулку на лодке по каналам города и Озеру Любви, однако не надо забывать, что Венгрия поднимает живописный официальный язык. Южное полушарие изящно отталкивает Карибский бассейн, при этом его стоимость значительно ниже, чем в бутылках.',
                'text' => "Рекомендуется совершить прогулку на лодке по каналам города и Озеру Любви, однако не надо забывать, что Венгрия поднимает живописный официальный язык. Южное полушарие изящно отталкивает Карибский бассейн, при этом его стоимость значительно ниже, чем в бутылках. Вулканизм дегустирует городской ксерофитный кустарник. Горная область надкусывает городской вечнозеленый кустарник, причем мужская фигурка устанавливается справа от женской. Для пользования телефоном-автоматом необходимы разменные монеты, однако Большое Медвежье озеро дешево. Площадь откровенна.
                    Типичная европейская буржуазность и добропорядочность, по определению, начинает попугай. В турецких банях не принято купаться раздетыми, поэтому из полотенца сооружают юбочку, а официальный язык теоретически возможен. Официальный язык недоступно надкусывает символический центр современного Лондона.
                    Утконос притягивает городской склон Гиндукуша. Поваренная соль входит материк. Гвианский щит совершает Бенгальский залив."
            ], [
                'title' => "Эксклюзивный принцип восприятия: методология и особенности",
                'preview' => 'В соответствии с законом Ципфа, рыночная информация тормозит конструктивный жизненный цикл продукции. Поэтому узнавание бренда программирует портрет потребителя. Косвенная реклама притягивает конструктивный показ баннера, оптимизируя бюджеты.',
                'text' => "В соответствии с законом Ципфа, рыночная информация тормозит конструктивный жизненный цикл продукции. Поэтому узнавание бренда программирует портрет потребителя. Косвенная реклама притягивает конструктивный показ баннера, оптимизируя бюджеты. Не факт, что product placement категорически создает ролевой рейтинг.
                    Интересно отметить, что продвижение проекта тормозит популярный целевой трафик. Более того, организация слубы маркетинга повсеместно индуцирует показ баннера. Фокус-группа парадоксально концентрирует анализ рыночных цен. Интересно отметить, что воздействие на потребителя тормозит нестандартный подход, повышая конкуренцию.
                    Интересно отметить, что соц-дем характеристика аудитории последовательно индуцирует ролевой план размещения. Бюджет на размещение, следовательно, директивно притягивает рыночный рейтинг. Емкость рынка, согласно Ф.Котлеру, однообразно допускает коллективный медиамикс, оптимизируя бюджеты. Стратегический рыночный план без оглядки на авторитеты масштабирует потребительский имидж. Стратегический маркетинг, на первый взгляд, концентрирует комплексный портрет потребителя, осознавая социальную ответственность бизнеса. Опрос основательно подпорчен предыдущим опытом применения."
            ], [
                'title' => "Партисипативное планирование как маркетинг",
                'preview' => 'Такое понимание ситуации восходит к Эл Райс, при этом стратегическое планирование стремительно отражает креативный портрет потребителя, учитывая результат предыдущих медиа-кампаний. Продвижение проекта настроено позитивно. Интеграция, на первый взгляд, традиционно обуславливает контент.',
                'text' => "Такое понимание ситуации восходит к Эл Райс, при этом стратегическое планирование стремительно отражает креативный портрет потребителя, учитывая результат предыдущих медиа-кампаний. Продвижение проекта настроено позитивно. Интеграция, на первый взгляд, традиционно обуславливает контент.
                    Имиджевая реклама, конечно, методически детерминирует комплексный рекламный бриф. Медийный канал оправдывает клиентский спрос. Интересно отметить, что контент специфицирует обществвенный PR. Такое понимание ситуации восходит к Эл Райс, при этом корпоративная культура поддерживает типичный продуктовый ассортимент, оптимизируя бюджеты.
                    Надо сказать, что емкость рынка раскручивает экспериментальный SWOT-анализ, опираясь на опыт западных коллег. Повышение жизненных стандартов тормозит коллективный нишевый проект. Таргетирование индуцирует потребительский рынок."
            ],
        ];

        foreach ($categories as $category_id => $category_name) {
            foreach ($news_for_category as $news) {
                $days = rand(1, 10);
                $news_date = (new DateTime())->sub(new DateInterval('P'.$days.'D'));
                $news_title = $category_name.'. '.$news['title'];
                $this->insert('news', [
                    'category_id' => $category_id,
                    'is_active'   => 1,
                    'title'       => $news_title,
                    'trans_title' => TextHelper::transliterate($news_title),
                    'preview'     => $news['preview'],
                    'text'        => $news['text'],
                    'created_at'  => $news_date->format("Y-m-d H:m:s"),
                    'updated_at'  => $news_date->format("Y-m-d H:m:s")
                ]);
            }
        }
    }

    public function safeDown() {
        $this->delete('posts');
        $this->delete('news');
        $this->delete('categories');

        return true;
    }
}
