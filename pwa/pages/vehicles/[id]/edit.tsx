import {
  GetStaticPaths,
  GetStaticProps,
  NextComponentType,
  NextPageContext,
} from "next";
import DefaultErrorPage from "next/error";
import Head from "next/head";
import { useRouter } from "next/router";
import { dehydrate, QueryClient, useQuery } from "react-query";

import { Form } from "../../../components/vehicle/Form";
import { PagedCollection } from "../../../types/collection";
import { Vehicle } from "../../../types/Vehicle";
import { fetch, FetchResponse, getItemPaths } from "../../../utils/dataAccess";

const getVehicle = async (id: string | string[] | undefined) =>
  id ? await fetch<Vehicle>(`/vehicles/${id}`) : Promise.resolve(undefined);

const Page: NextComponentType<NextPageContext> = () => {
  const router = useRouter();
  const { id } = router.query;

  const { data: { data: vehicle } = {} } = useQuery<
    FetchResponse<Vehicle> | undefined
  >(["vehicle", id], () => getVehicle(id));

  if (!vehicle) {
    return <DefaultErrorPage statusCode={404} />;
  }

  return (
    <div>
      <div>
        <Head>
          <title>{vehicle && `Edit Vehicle ${vehicle["@id"]}`}</title>
        </Head>
      </div>
      <Form vehicle={vehicle} />
    </div>
  );
};

export const getStaticProps: GetStaticProps = async ({
  params: { id } = {},
}) => {
  if (!id) throw new Error("id not in query param");
  const queryClient = new QueryClient();
  await queryClient.prefetchQuery(["vehicle", id], () => getVehicle(id));

  return {
    props: {
      dehydratedState: dehydrate(queryClient),
    },
    revalidate: 1,
  };
};

export const getStaticPaths: GetStaticPaths = async () => {
  const response = await fetch<PagedCollection<Vehicle>>("/vehicles");
  const paths = await getItemPaths(response, "vehicles", "/vehicles/[id]/edit");

  return {
    paths,
    fallback: true,
  };
};

export default Page;
