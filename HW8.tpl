<html>
    <head>
        <title>HW8</title>
    </head>
    <body>
        <form method="POST">
            {if isset($type)}
                <p>{html_radios name='type' options=$radio_array selected=$type}</p>
            {else}
                <p>{html_radios name='type' options=$radio_array selected='0'}</p>
            {/if}
            <p>Ваше имя <input type="text" name="name" value='{if isset($name)}{$name}{/if}'/></p>
            <p>Электронная почта <input type="email" name="email" value='{if isset($email)}{$email}{/if}'/></p>
            {if (isset($otvet))}
                {if ($otvet == 'on')}
                    <p><input type="checkbox" name="otvet" checked='cheked'/> Я не хочу получать ответы по объявлению по e-mail </p>
                {else}
                    <p><input type="checkbox" name="otvet"/> Я не хочу получать ответы по объявлению по e-mail </p>
                {/if}
            {else}
                 <p><input type="checkbox" name="otvet"/> Я не хочу получать ответы по объявлению по e-mail </p>
            {/if}
            <p>Номер телефона <input type="tel" name="phone" value='{if isset($phone)}{$phone}{/if}'/></p>
            <p><select name="city">
                {if isset($city)}
                    {html_options options=$cities selected=$city}
                {else}
                    {html_options options=$cities}
                {/if}
            </select></p>
            <p><select name="category">
                {if isset($category)}
                    {html_options options=$categories selected=$category}
                {else}
                    {html_options options=$categories}
                {/if}
            </select></p>
            <p>Название объявления <input type="text" name="ad_title" value='{if isset($ad_title)}{$ad_title}{/if}'/></p>
            <p>Описание объявления <textarea name="ad_description">{if isset($ad_description)}{$ad_description}{/if}</textarea></p>
            <p>Цена <input type="number" name="price" min="0" max="100000" value='{if isset($price)}{$price}{else}0{/if}' /> руб</p>
            <input type="submit" name="submit">
        </form>
        {if !isset($smarty.get.id)}
            {showAd}
        {else}
            <a href="HW8.php">Главная страница</a>
        {/if}
    </body>
</html>