pipeline {
    agent any

    environment {
        SONAR_TOKEN = credentials('Sonarqube')
    }

    stages {
        stage('Clonar Repositorio') {
            steps {
                timeout(time: 2, unit: 'MINUTES') {
                    git branch: 'main',
                        credentialsId: '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',
                        url: 'https://github.com/enders9245/examen.git'
                }
            }
        }

        stage('Instalar Dependencias con Composer') {
            steps {
                timeout(time: 8, unit: 'MINUTES') {
                    sh '''
                        cd reservasback
                        composer install
                    '''
                }
            }
        }

        stage('Configurar Entorno Laravel') {
            steps {
                timeout(time: 2, unit: 'MINUTES') {
                    sh '''
                        cd reservasback

                        if [ ! -f .env ]; then
                          cp .env.example .env
                        fi

                        if [ ! -f .env.testing ]; then
                          cp .env .env.testing
                        fi

                        php artisan key:generate
                    '''
                }
            }
        }

        stage('Migrar y Poblar Base de Datos') {
            steps {
                timeout(time: 3, unit: 'MINUTES') {
                    sh '''
                        cd reservasback
                        php artisan config:clear
                        php artisan migrate:fresh --seed || echo "Migración falló"
                    '''
                }
            }
        }

        stage('Ejecutar Pruebas y Generar Cobertura') {
            steps {
                timeout(time: 5, unit: 'MINUTES') {
                    sh '''
                        cd reservasback
                        ./vendor/bin/phpunit --configuration phpunit.xml --coverage-clover storage/coverage.xml
                    '''
                }
            }
        }

        stage('Análisis con SonarQube') {
            steps {
                withSonarQubeEnv('sonarqube') {
                    sh '''
                        cd reservasback
                        sonar-scanner \
                        -Dsonar.projectKey=Capachica \
                        -Dsonar.sources=app \
                        -Dsonar.tests=tests \
                        -Dsonar.php.coverage.reportPaths=storage/coverage.xml \
                        -Dsonar.host.url=http://sonarqube:9000 \
                        -Dsonar.token=$SONAR_TOKEN
                    '''
                }
            }
        }

        stage('Quality Gate') {
            steps {
                sleep(time: 10, unit: 'SECONDS')
                timeout(time: 2, unit: 'MINUTES') {
                    waitForQualityGate abortPipeline: true
                }
            }
        }

        stage('Despliegue (Simulado)') {
            steps {
                echo '✅ Simulación de despliegue completada.'
            }
        }
    }

    post {
        success {
            echo '✅ Pipeline ejecutado con éxito.'
        }
        failure {
            echo '❌ Error en alguna etapa del pipeline.'
        }
    }
}
