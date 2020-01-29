<?php
namespace Murilo\Pagamento\Cnab\Retorno\Cnab240;

use Carbon\Carbon;
use Exception;
use Murilo\Pagamento\Contracts\Cnab\Retorno\Cnab240\Detalhe as DetalheContract;
use Murilo\Pagamento\Contracts\Pessoa as PessoaContract;
use Murilo\Pagamento\Contracts\Conta as ContaContract;
use Murilo\Pagamento\Traits\MagicTrait;
use Murilo\Pagamento\Util;

/**
 * Class Detalhe
 * @package Murilo\Pagamento\Cnab\Retorno\Cnab240
 */
class Detalhe implements DetalheContract
{
    use MagicTrait;

    /**
     * @var string
     */
    protected $ocorrencia;

    /**
     * @var string
     */
    protected $ocorrenciaTipo;

    /**
     * @var string
     */
    protected $ocorrenciaDescricao;

    /**
     * @var int
     */
    protected $numeroControle;

    /**
     * @var string
     */
    protected $numeroDocumento;

    /**
     * @var string
     */
    protected $nossoNumero;

    /**
     * @var string
     */
    protected $carteira;

    /**
     * @var Carbon
     */
    protected $dataVencimento;

    /**
     * @var Carbon
     */
    protected $dataOcorrencia;

    /**
     * @var Carbon
     */
    protected $dataCredito;

    /**
     * @var string
     */
    protected $valor;

    /**
     * @var string
     */
    protected $valorRecebido;

    /**
     * @var string
     */
    protected $valorIOF;

    /**
     * @var string
     */
    protected $valorAbatimento;

    /**
     * @var string
     */
    protected $valorDesconto;

    /**
     * @var string
     */
    protected $valorMora;

    /**
     * @var string
     */
    protected $valorMulta;

    /**
     * @var PessoaContract
     */
    protected $pagador;

    /**
     * @var PessoaContract
     */
    protected $favorecido;

    /**
     * @var ContaContract
     */
    protected $contaFavorecido;

    /**
     * @var ContaContract
     */
    protected $contaPagador;

    /**
     * @var array
     */
    protected $cheques = [];

    /**
     * @var string
     */
    protected $error;

    /**
     * @return string
     */
    public function getOcorrencia()
    {
        return $this->ocorrencia;
    }

    /**
     * @return boolean
     */
    public function hasOcorrencia()
    {
        $ocorrencias = func_get_args();

        if (count($ocorrencias) == 0 && !empty($this->getOcorrencia())) {
            return true;
        }

        if (count($ocorrencias) == 1 && is_array(func_get_arg(0))) {
            $ocorrencias = func_get_arg(0);
        }

        if (in_array($this->getOcorrencia(), $ocorrencias)) {
            return true;
        }

        return false;
    }

    /**
     * @param string $ocorrencia
     *
     * @return $this
     */
    public function setOcorrencia($ocorrencia)
    {
        $this->ocorrencia = $ocorrencia;

        return $this;
    }

    /**
     * @return string
     */
    public function getOcorrenciaTipo()
    {
        return $this->ocorrenciaTipo;
    }

    /**
     * @param string $ocorrenciaTipo
     *
     * @return $this
     */
    public function setOcorrenciaTipo($ocorrenciaTipo)
    {
        $this->ocorrenciaTipo = $ocorrenciaTipo;

        return $this;
    }

    /**
     * @return string
     */
    public function getOcorrenciaDescricao()
    {
        return $this->ocorrenciaDescricao;
    }

    /**
     * @param string $ocorrenciaDescricao
     *
     * @return $this
     */
    public function setOcorrenciaDescricao($ocorrenciaDescricao)
    {
        $this->ocorrenciaDescricao = $ocorrenciaDescricao;

        return $this;
    }

    /**
     * @return string
     */
    public function getNumeroDocumento()
    {
        return $this->numeroDocumento;
    }

    /**
     * @param string $numeroDocumento
     *
     * @return $this
     */
    public function setNumeroDocumento($numeroDocumento)
    {
        $this->numeroDocumento = $numeroDocumento;

        return $this;
    }

    /**
     * @return string
     */
    public function getNossoNumero()
    {
        return $this->nossoNumero;
    }

    /**
     * @param string $nossoNumero
     *
     * @return $this
     */
    public function setNossoNumero($nossoNumero)
    {
        $this->nossoNumero = $nossoNumero;

        return $this;
    }

    /**
     * @param string $format
     *
     * @return Carbon|null|string
     */
    public function getDataVencimento($format = 'd/m/Y')
    {
        return $this->dataVencimento instanceof Carbon
            ? $format === false ? $this->dataVencimento : $this->dataVencimento->format($format)
            : null;
    }

    /**
     * @param $dataVencimento
     *
     * @param string $format
     *
     * @return $this
     */
    public function setDataVencimento($dataVencimento, $format = 'dmY')
    {
        $this->dataVencimento = trim($dataVencimento, '0 ') ? Carbon::createFromFormat($format, $dataVencimento) : null;

        return $this;
    }

    /**
     * @param string $format
     *
     * @return Carbon|null|string
     */
    public function getDataCredito($format = 'd/m/Y')
    {
        return $this->dataCredito instanceof Carbon
            ? $format === false ? $this->dataCredito : $this->dataCredito->format($format)
            : null;
    }

    /**
     * @param $dataCredito
     *
     * @param string $format
     *
     * @return $this
     */
    public function setDataCredito($dataCredito, $format = 'dmY')
    {
        $this->dataCredito = trim($dataCredito, '0 ') ? Carbon::createFromFormat($format, $dataCredito) : null;

        return $this;
    }

    /**
     * @param string $format
     *
     * @return Carbon|null|string
     */
    public function getDataOcorrencia($format = 'd/m/Y')
    {
        return $this->dataOcorrencia instanceof Carbon
            ? $format === false ? $this->dataOcorrencia : $this->dataOcorrencia->format($format)
            : null;
    }

    /**
     * @param $dataOcorrencia
     *
     * @param string $format
     *
     * @return $this
     */
    public function setDataOcorrencia($dataOcorrencia, $format = 'dmY')
    {
        $this->dataOcorrencia = trim($dataOcorrencia, '0 ') ? Carbon::createFromFormat($format, $dataOcorrencia) : null;

        return $this;
    }

    /**
     * @return string
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * @param string $valor
     *
     * @return $this
     */
    public function setValor($valor)
    {
        $this->valor = $valor;

        return $this;
    }

    /**
     * @return string
     */
    public function getValorIOF()
    {
        return $this->valorIOF;
    }

    /**
     * @param string $valorIOF
     *
     * @return $this
     */
    public function setValorIOF($valorIOF)
    {
        $this->valorIOF = $valorIOF;

        return $this;
    }

    /**
     * @return string
     */
    public function getValorAbatimento()
    {
        return $this->valorAbatimento;
    }

    /**
     * @param string $valorAbatimento
     *
     * @return $this
     */
    public function setValorAbatimento($valorAbatimento)
    {
        $this->valorAbatimento = $valorAbatimento;

        return $this;
    }

    /**
     * @return string
     */
    public function getValorDesconto()
    {
        return $this->valorDesconto;
    }

    /**
     * @param string $valorDesconto
     *
     * @return $this
     */
    public function setValorDesconto($valorDesconto)
    {
        $this->valorDesconto = $valorDesconto;

        return $this;
    }

    /**
     * @return string
     */
    public function getValorMora()
    {
        return $this->valorMora;
    }

    /**
     * @param string $valorMora
     *
     * @return $this
     */
    public function setValorMora($valorMora)
    {
        $this->valorMora = $valorMora;

        return $this;
    }

    /**
     * @return string
     */
    public function getValorMulta()
    {
        return $this->valorMulta;
    }

    /**
     * @param string $valorMulta
     *
     * @return $this
     */
    public function setValorMulta($valorMulta)
    {
        $this->valorMulta = $valorMulta;

        return $this;
    }

    /**
     * @return string
     */
    public function getValorRecebido()
    {
        return $this->valorRecebido;
    }

    /**
     * @param string $valorRecebido
     *
     * @return $this
     */
    public function setValorRecebido($valorRecebido)
    {
        $this->valorRecebido = $valorRecebido;

        return $this;
    }

    /**
     * @return PessoaContract
     */
    public function getPagador()
    {
        return $this->pagador;
    }

    /**
     * @param $pagador
     *
     * @return $this
     * @throws Exception
     */
    public function setPagador($pagador)
    {
        Util::addPessoa($this->pagador, $pagador);
        return $this;
    }

    /**
     * @return PessoaContract
     */
    public function getFavorecido()
    {
        return $this->favorecido;
    }

    /**
     * @param $favorecido
     *
     * @return $this
     * @throws Exception
     */
    public function setFavorecido($favorecido)
    {
        Util::addPessoa($this->favorecido, $favorecido);
        return $this;
    }

    /**
     * @return ContaContract
     */
    public function getContaPagador()
    {
        return $this->contaPagador;
    }

    /**
     * @param $contaPagador
     *
     * @return $this
     * @throws Exception
     */
    public function setContaPagador($contaPagador)
    {
        Util::addConta($this->contaPagador, $contaPagador);
        return $this;
    }

    /**
     * @return ContaContract
     */
    public function getContaFavorecido()
    {
        return $this->contaFavorecido;
    }

    /**
     * @param $contaFavorecido
     *
     * @return $this
     * @throws Exception
     */
    public function setContaFavorecido($contaFavorecido)
    {
        Util::addConta($this->contaFavorecido, $contaFavorecido);
        return $this;
    }

    /**
     * Retorna se tem erro.
     *
     * @return bool
     */
    public function hasError()
    {
        return $this->getOcorrencia() == self::OCORRENCIA_ERRO;
    }

    /**
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @param string $error
     *
     * @return $this
     */
    public function setError($error)
    {
        $this->ocorrenciaTipo = self::OCORRENCIA_ERRO;
        $this->error = $error;

        return $this;
    }
}
