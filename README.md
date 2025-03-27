# Boilerplate

## Tecnologias Utilizadas

### Under the Hood
- [**ES6**](https://github.com/lukehoban/es6features#readme): JavaScript moderno, transpilado com [Babel](https://babeljs.io/) e lintado com [ESLint](https://eslint.org/).
- [**SASS**](http://sass-lang.com/): Preprocessador CSS seguindo as [SASS Guidelines](https://sass-guidelin.es/#the-7-1-pattern).
- [**Bootstrap 5**](https://getbootstrap.com/docs/5.2/getting-started/introduction/): Framework CSS customizável via [SASS](https://getbootstrap.com/docs/5.2/customize/sass/).
- [**Gulp 4**](https://gulpjs.com/) e [**Webpack 5**](https://webpack.js.org/): Ferramentas para gerenciar, compilar e otimizar os assets do tema.
- **SVG Sprite**: Crie uma pasta como assets/src/svg/ com seus SVGs e execute o comando de build ou watch.

## Requisitos
Para utilizar este tema, certifique-se de atender aos seguintes requisitos:

- **Node.js**: Versão >= 16.0.0
- **npm**: Versão >= 8.0.0
- **Gulp**: Instalado globalmente (veja [Quick Start](https://gulpjs.com/docs/en/getting-started/quick-start))

## Instalação e Uso
*Passo a Passo*
1. **Clone o Repositório**
Clone este repositório no seu local de projetos.
```bash
git clone git@gitlab.dzigual.com.br:mint/nome-do-projeto
```

2. **Inicie o container do projeto**
Dentro do projeto, rode no terminal:
```bash
docker compose up -d
```

3. **Instale as Dependências**
No diretório do tema, execute:
```bash
npm install
```

4. **Gere o Build para Produção**
Para compilar os assets em tempo real durante o desenvolvimento:
```bash
npm run start
```

5. **Inicie o Watch para Desenvolvimento**
Para criar uma versão otimizada para produção:
```bash
npm run build
```

6. **Compile e Minifique o JavaScript**
Para compilar e minificar os arquivos JS separadamente:
```bash
npm run build-compiled
```

## Estrutura e Desenvolvimento

### Sistema de Módulos Dinâmicos
O tema utiliza um sistema de módulos dinâmicos baseado em jQuery para carregar scripts sob demanda. Veja um exemplo da função initDynamicModules:

```javascript
function initDynamicModules() {
  async function loadDynamicModule(selector, modulePath, moduleFunction) {
    const elements = $(selector);
    if (elements.length > 0) {
      try {
        const module = await import(`${modulePath}`);
        module[moduleFunction]();
      } catch (error) {
        console.error(`Erro ao carregar/executar o módulo ${selector}: `, error);
      }
    }
  }

  const dynamicModules = [
    {
      selector: '.page-template-homepage',
      modulePath: './pages/home/homepage.js',
      moduleFunction: 'initHomePage',
    },
    {
      selector: 'header',
      modulePath: './base/header.js',
      moduleFunction: 'initHeader',
    },
  ];

  dynamicModules.forEach(({ selector, modulePath, moduleFunction }) => {
    loadDynamicModule(selector, modulePath, moduleFunction);
  });
}

export { initDynamicModules };
```

### Como Funciona
- **selector**: Seletor jQuery presente na página.
- **modulePath**: Caminho relativo ao arquivo JavaScript do módulo.
- **moduleFunction**: Função exportada pelo módulo (ex.: export { funcName }).

### Observações
- Os módulos podem importar outros módulos usando import { funcName } from '../relative-path/module.js'.

### Adicionando SCSS
- **Caminho**: Use assets/src/scss e organize nos diretórios existentes.
- **Importação**: Adicione o novo arquivo ao main.scss.
- **Seletor**: Use body.(classe-da-pagina) gerado por body_class() no header.php.

### Adicionando Imagens
- **Caminho**: Use assets/src/img.

### Adicionando SVGs
- **Caminho**: Use assets/src/svg.

### Utilizar WPCLI no Docker:
Execute o comando abaixo para o script `wpcli` estar disponível fora do container:
```bash
docker exec wp core version
```