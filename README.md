# simplesm2
该项目是在 https://github.com/lpilp/phpsm2sm3sm4 的基础上做了简化， 只保留使用php-gmp组件，使用yum安装时直接安装就可，asn1针对本项目进行了降级处理， ecc中只用到了point类 都已独立
## 要求
  * php >=5.6  64位php,  5.4的一堆报错，实在没法改
  * 安装gmp组件 检测方法  php -m | grep gmp 
